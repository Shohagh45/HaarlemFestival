<?php
namespace repositories;
use config\dbconfig;
use PDO;
use PDOException;
use model\Event;
use model\Ticket;
use model\Jazz;
require_once __DIR__ .'/../config/dbconfig.php';
require_once __DIR__ . '/../model/event.php';
require_once __DIR__ . '/../model/ticket.php';
require_once __DIR__ . '/../model/jazz.php';

Class jazzrepository extends dbconfig{

    public function  getEventdetails($eventid = "6"){

        $sql = 'SELECT* FROM Event WHERE event_id = :eventID;';

        try{
            $stmt = $this->getConnection()->prepare($sql);
            $stmt -> bindParam(':eventID',$eventid,PDO::PARAM_INT);
            $stmt-> execute();
            
            $stmt->setFetchMode(PDO::FETCH_CLASS, Event::class);
            $event = $stmt->fetch();
            return $event;

        }catch(PDOException $e){
            echo "Error: ". $e->getMessage();
            return null;

        }
    }
   /* public function getTicketsForEvent($eventId)
    {
        $sql = 'SELECT * FROM [Ticket] WHERE event_id = :event_id  AND user_id IS NULL;';

        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->execute();


            $ticketsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $tickets = [];
            foreach ($ticketsData as $ticketData) {
                $ticket = new Ticket();
                $ticket->setTicketId($ticketData['ticket_id']);
                $ticket->setUserId($ticketData['user_id'] ?? null);
                $ticket->setQuantity($ticketData['quantity']);
                $ticket->setTicketHash($ticketData['ticket_hash']);
                $ticket->setState($ticketData['state']);
                $ticket->setEventId($ticketData['event_id']);
                $ticket->setTicketLanguage($ticketData['language']);
                $ticket->setTicketDate($ticketData['Date']);
                $ticket->setTicketTime($ticketData['Time']);

                $tickets[] = $ticket;
            }

            return $tickets;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    */
    public function getAvailableJazzEvents($eventId)
    {
        $sql = 'SELECT * FROM [Event] WHERE event_id = :event_id AND user_id IS NULL;';
    
        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->execute();
    
            $eventsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $events = [];
            foreach ($eventsData as $eventData) {
                $event = new \model\Jazz(); // Assuming you have a Jazz event class
                $event->setArtistName($eventData['artistName']);
                $event->setTime($eventData['time']);
                $event->setLocation($eventData['location']);
                $event->setPrice($eventData['price']);
               // $event->setReserved($eventData['reserved']);
    
                $events[] = $event;
            }
    
            return $events;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

      
  /*  public function addNewTimeSlot(Ticket $newTicket) {
        $checkSql = "SELECT COUNT(*) FROM Ticket WHERE event_id = :eventId AND Date = :date AND Time = :time AND artist_name = :artistName";
        
        try {
            $checkStmt = $this->getConnection()->prepare($checkSql);
            $checkStmt->bindValue(':eventId', $newTicket->getEventId());
            $checkStmt->bindValue(':date', $newTicket->getTicketDate());
            $checkStmt->bindValue(':time', $newTicket->getTicketTime());
            $checkStmt->bindValue(':artistName', $newTicket->getArtistName());
            $checkStmt->execute();
    
            $existingTicketCount = $checkStmt->fetchColumn();
    
            if ($existingTicketCount > 0) {
                error_log("A ticket with the same date, time, and artist name already exists.");
                return false;
            }
    
            $insertSql = "INSERT INTO Ticket (quantity, ticket_hash, state, event_id, artist_name, Date, Time)
                          VALUES (:quantity, :ticket_hash, :state, :event_id, :artist_name, :date, :time)";
    
            $insertStmt = $this->getConnection()->prepare($insertSql);
            $insertStmt->bindValue(':quantity', $newTicket->getQuantity());
            $insertStmt->bindValue(':ticket_hash', $newTicket->getTicketHash());
            $insertStmt->bindValue(':state', $newTicket->getState());
            $insertStmt->bindValue(':event_id', $newTicket->getEventId());
            $insertStmt->bindValue(':artist_name', $newTicket->getArtistName());
            $insertStmt->bindValue(':date', $newTicket->getTicketDate());
            $insertStmt->bindValue(':time', $newTicket->getTicketTime());
            $insertStmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
    */
    public function addNewJazzTimeSlot(Jazz $newEvent) {
        $checkSql = "SELECT COUNT(*) FROM Event WHERE event_id = :eventId AND Date = :date AND Time = :time AND artist_name = :artistName";
        
        try {
            $checkStmt = $this->getConnection()->prepare($checkSql);
           // $checkStmt->bindValue(':eventId', $newEvent->getEventId());
            $checkStmt->bindValue(':date', $newEvent->getTime()); // Assuming Jazz events have a time field
            $checkStmt->bindValue(':time', $newEvent->getTime());
            $checkStmt->bindValue(':artistName', $newEvent->getArtistName());
            $checkStmt->execute();
    
            $existingEventCount = $checkStmt->fetchColumn();
    
            if ($existingEventCount > 0) {
                error_log("An event with the same date, time, and artist name already exists.");
                return false;
            }
    
            $insertSql = "INSERT INTO Event (artistName, time, location, price, reserved)
                          VALUES (:artistName, :time, :location, :price, :reserved)";
    
            $insertStmt = $this->getConnection()->prepare($insertSql);
            $insertStmt->bindValue(':artistName', $newEvent->getArtistName());
            $insertStmt->bindValue(':time', $newEvent->getTime());
            $insertStmt->bindValue(':location', $newEvent->getLocation());
            $insertStmt->bindValue(':price', $newEvent->getPrice());
            $insertStmt->bindValue(':reserved', $newEvent->isReserved() ? 1 : 0); // Assuming reserved is boolean
            $insertStmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
 
 /*   
public function existEvent($newEventName, $eventId){
    $sql = "SELECT COUNT(*) FROM [Event] WHERE name = :name AND event_id != :eventId";
    try {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $newEventName, PDO::PARAM_STR);
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $stmt->execute();

        $count = $stmt->fetchColumn();
        return $count > 0 ? false : true;
    } catch (PDOException $e) {
        error_log(''. $e->getMessage());
        return false; 
    }
}
public function removeTimeslot($ticketID){
    $sql = "DELETE FROM [Ticket] WHERE ticket_id = :ticketid AND user_id IS NULL;";
    try {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':ticketid', $ticketID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        error_log(''. $e->getMessage());
        return false; 
    }
}
*/

public function existEvent($newEventName, $eventId){
    $sql = "SELECT COUNT(*) FROM Event WHERE artistName = :name AND event_id != :eventId";
    try {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $newEventName, PDO::PARAM_STR);
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $stmt->execute();

        $count = $stmt->fetchColumn();
        return $count > 0 ? false : true;
    } catch (PDOException $e) {
        error_log(''. $e->getMessage());
        return false; 
    }
}
public function removeJazzEvent($eventId){
    $sql = "DELETE FROM Event WHERE event_id = :eventId";
    try {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        error_log(''. $e->getMessage());
        return false; 
    }
}
/*
public function editEventDetails($eventId, $eventName, $eventDate,$eventTime, $price, $picture,$newLocation,$artistName){
             $sql = "UPDATE Event SET 
              name = :eventName, 
              event_date = :eventDate, 
             location = :location, 
             price = :price,
             picture = :picture,
             artist_name = :artistName,
             event_time = :eventTime
             WHERE event_id = :eventId";
    try {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':eventName', $eventName, PDO::PARAM_STR);
        $stmt->bindParam(':eventDate', $eventDate, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':location', $newLocation, PDO::PARAM_STR);
        $stmt->bindParam(':picture', $picture, PDO::PARAM_STR);
        $stmt->bindParam(':artistName', $artistName, PDO::PARAM_STR);
        $stmt->bindParam(':eventTime', $eventTime, PDO::PARAM_STR);
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);

        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Error updating event details: " . $e->getMessage());
        return false;
    }
}
*/
public function editJazzEventDetails($eventId, $artistName, $eventDate, $eventTime, $price, $location, $picture) {
    $sql = "UPDATE Event SET 
              artistName = :artistName, 
              time = :eventTime, 
              location = :location, 
              price = :price,
              picture = :picture
              WHERE event_id = :eventId";
    try {
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':artistName', $artistName, PDO::PARAM_STR);
        $stmt->bindParam(':eventDate', $eventDate, PDO::PARAM_STR); // Assuming you have a date field in your Event table
        $stmt->bindParam(':eventTime', $eventTime, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);
        $stmt->bindParam(':picture', $picture, PDO::PARAM_STR);
        $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);

        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Error updating Jazz event details: " . $e->getMessage());
        return false;
    }
}


}
