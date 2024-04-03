<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use DateTime;
use model\Resturant;
use model\Ticket;

require_once __DIR__ . '/../config/dbconfig.php';
require_once __DIR__ . '/../model/resturant.php';
require_once __DIR__ . '/../model/ticket.php';


class resturantrepository extends dbconfig {
    public function getAllRestaurants() {
        $restaurants = [];
        try {
            $stmt = $this->connection->prepare("SELECT * FROM [Event] WHERE NAME = 'Restaurant'");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($results as $result) {
                $restaurant = new \model\Restaurant();
                $restaurant->setId($result['event_id']);
                $restaurant->setLocation($result['location']);
                $restaurant->setPrice($result['price']);
                $restaurant->setSeats(isset($result['seats']) ? (int)$result['seats'] : null);
                $restaurant->setStartDate($result['startDate']);
                $restaurant->setEndDate($result['endDate']);
                $restaurant->setPicture($result['picture']);
                $restaurants[] = $restaurant;
            }
            
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
        return $restaurants;
    }
    
    public function updateRestaurantDetails($id, $name, $price, $seats, $startDate, $endDate, $picturePath) {
        try {
            $sql = "UPDATE [Event] SET location = :location, price = :price, seats = :seats, startDate = :startDate, endDate = :endDate";
            
            if (!empty($picturePath)) {
                $sql .= ", picture = :picture";
            }
    
            $sql .= " WHERE event_id = :id";
    
            $stmt = $this->connection->prepare($sql);
    
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':location', $name);
            $stmt->bindValue(':price', $price);
            $stmt->bindValue(':seats', $seats, PDO::PARAM_INT);
            $stmt->bindValue(':startDate', $startDate);
            $stmt->bindValue(':endDate', $endDate);
    
            if (!empty($picturePath)) {
                $stmt->bindValue(':picture', $picturePath);
            }
    
            $stmt->execute();
    
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function getTicketTimeslotsForResturant($id) {
        $times = [];
        try {
            $stmt = $this->connection->prepare("SELECT [Time] FROM [Ticket] WHERE event_id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($results as $result) {
                $times[] = $result['time'];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
        return $times;
    }
    
    public function addTimeSlot($restaurantId, $ticket_hash, $date, $time, $quantity) {
        try {
            $stmt = $this->connection->prepare("INSERT INTO [Ticket] (event_id, ticket_hash, date, time, quantity, state) VALUES (:restaurantId, :ticket_hash, :date, :time, :quantity, :state)");
    
            $stmt->bindValue(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $stmt->bindValue(':ticket_hash', $ticket_hash);
            $stmt->bindValue(':date', $date);
            $stmt->bindValue(':time', $time);
            $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindValue(':state', 'Not Used');
    
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getTicketTimeslotsForRestaurant() {
        $timeslots = [];
    
        try {
            $stmt = $this->connection->prepare("SELECT [Event].event_id, [Event].[location], Ticket.[Date], Ticket.[Time], Ticket.quantity FROM [Event] JOIN Ticket ON [Event].event_id = Ticket.event_id WHERE [Event].[name] = :eventName");
    
            $stmt->bindValue(':eventName', 'Restaurant');
    
            $stmt->execute();
    
            $ticketResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($ticketResults as $ticketResult) {
                $ticket = new \model\Ticket();
                $ticket->setEventId($ticketResult['event_id']);
                $ticket->setQuantity($ticketResult['quantity']);
                $ticket->setTicketDate($ticketResult['Date']);
                $ticket->setTicketTime($ticketResult['Time']);
    
                $timeslots[] = $ticket;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    
        return $timeslots;
    }


    public function getRestaurantByIdWithTimeslots($restaurantId) {
        $restaurantDetails = null;
        $timeslots = [];
    
        try {
            // Fetch restaurant and event details
            $stmt = $this->connection->prepare(
                "SELECT *
                 FROM Restaurant 
                 JOIN [Event] ON Restaurant.resturant_id = [Event].restaurant_id
                 WHERE Restaurant.resturant_id = :restaurantId"
            );
    
            $stmt->bindValue(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            if ($results) {
                foreach ($results as $result) {
                    if (!$restaurantDetails) {
                        $restaurantDetails = new \model\Restaurant();
                        $restaurantDetails->setId($result['resturant_id'] ?? '');
                        $restaurantDetails->setLocation($result['location'] ?? '');
                        $restaurantDetails->setName($result['name'] ?? '');
                        $restaurantDetails->setPrice($result['price'] ?? 0); // Assuming 0 is a sensible default for price
                        $restaurantDetails->setSeats(isset($result['seats']) ? (int)$result['seats'] : null);
                        $restaurantDetails->setStartDate($result['startDate'] ?? '');
                        $restaurantDetails->setEndDate($result['endDate'] ?? '');
                        $restaurantDetails->setPicture($result['picture'] ?? '');
                        $restaurantDetails->setEventId($result['event_id'] ?? '');
                    }
            
                    $ticketStmt = $this->connection->prepare("SELECT * FROM Ticket WHERE event_id = :eventId");
                    $ticketStmt->bindValue(':eventId', $restaurantDetails->getEventId(), PDO::PARAM_INT);
                    $ticketStmt->execute();
                    $ticketResults = $ticketStmt->fetchAll(PDO::FETCH_ASSOC);
            
                    foreach ($ticketResults as $ticketResult) {
                        $ticket = new \model\Ticket();
                        $ticket->setEventId($ticketResult['event_id'] ?? '');
                        $ticket->setTicketId($ticketResult['ticket_id'] ?? '');
                        $ticket->setTicketHash($ticketResult['ticket_hash'] ?? '');
                        $ticket->setTicketDate($ticketResult['Date'] ?? '');
                        $ticket->setTicketTime($ticketResult['Time'] ?? '');
                        $ticket->setQuantity($ticketResult['quantity'] ?? '');
                        $timeslots[] = $ticket;
                    }
                }
            }
            
            return ['restaurantDetails' => $restaurantDetails, 'timeslots' => $timeslots];
            
    
            return $restaurantDetails;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    

    
    public function addRestaurant($name, $location, $description, $price, $seats, $startDate, $endDate, $picturePath) {
        if (empty($name) || empty($location) || empty($description) || empty($price)) {
            return false;
        }
        try {
            $this->connection->beginTransaction();
            
            $pageRepository = new Pagerepository();
            $content = include __DIR__ . '/../config/resurantDefaultContent.php';
            $pageId = $pageRepository->createResturantPage($name, $content);
    

    
    
    
            return true;
        } catch (PDOException $e) {
            $this->connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function deleteTimeslot($ticket_hash){
        try {
            $stmt = $this->connection->prepare("DELETE FROM Ticket WHERE ticket_hash = :ticket_hash");
            $stmt->bindValue(':ticket_hash', $ticket_hash);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }

    }

    public function addReservation($ticket_id, $user_id, $specialRequest, $address, $firstName, $lastName, $phoneNumber) {
        try {
            $this->connection->beginTransaction();
            
            $stmtTicket = $this->connection->prepare("
                UPDATE Ticket 
                SET user_id = :user_id, 
                    state = 'Reserved', 
                    special_request = :specialRequest
                WHERE ticket_id = :ticket_id");
            $stmtTicket->bindValue(':ticket_id', $ticket_id);
            $stmtTicket->bindValue(':user_id', $user_id);
            $stmtTicket->bindValue(':specialRequest', $specialRequest);
            $stmtTicket->execute();
            
            $stmtUser = $this->connection->prepare("
                UPDATE [User] 
                SET address = :address, 
                    firstname = :firstname, 
                    lastname = :lastname, 
                    phone_number = :phone_number
                WHERE user_id = :user_id");
            $stmtUser->bindValue(':user_id', $user_id);
            $stmtUser->bindValue(':address', $address);
            $stmtUser->bindValue(':firstname', $firstName);
            $stmtUser->bindValue(':lastname', $lastName);
            $stmtUser->bindValue(':phone_number', $phoneNumber);
            $stmtUser->execute();
            
            $this->connection->commit();
            
            return true;
        } catch (PDOException $e) {
            $this->connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    



}