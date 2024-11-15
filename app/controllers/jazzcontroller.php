<?php

namespace controllers;

use model\Ticket;
use Exception;
use controllers\Navigationcontroller;
use controllers\Pagecontroller;
use services\JazzArtistService;
use services\JazzEventService;
use services\JazzVenueService;

require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../controllers/pagecontroller.php';
require_once __DIR__ . '/../services/JazzArtistService.php';
require_once __DIR__ . '/../services/JazzVenueService.php';
require_once __DIR__ . '/../services/JazzEventService.php';


class Jazzcontroller
{
    private $artistService;
    private $navigationController;
    private $eventService;
    private $venueService;
    public function __construct()
    {
        $this->navigationController = new NavigationController();
        $this->artistService = new JazzArtistService();
        $this->eventService = new JazzEventService();
        $this->venueService = new JazzVenueService();
    }

    public function show()
    {
        try {
            $navigation = $this->navigationController->displayHeader();
            $artists = $this->artistService->getAllArtists();
            $events = $this->eventService->getAllEvents();
            foreach ($events as $event) {
                $venue = $this->venueService->getVenueById($event->getVenueId());
                $event->setVenueName($venue->getName());
                $event->setLocation($venue->getLocation());
            }
            require_once __DIR__ . "/../views/jazz/overview.php";
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function showEventDetails()
    {
        try {
            $navigation = $this->navigationController->displayHeader();
            $eventId = $_GET['id'];
            $event = $this->eventService->getEventById($eventId);
            $venue = $this->venueService->getVenueById($event->getVenueId());
            $event->setVenueName($venue->getName());
            $event->setLocation($venue->getLocation());
            require_once __DIR__ . '/../views/jazz/details.php';
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function showArtistDetails()
    {
        try {
            $artistId = $_GET['id'];
            $navigation = $this->navigationController->displayHeader();
            $artist = $this->artistService->getArtistById($artistId);
            require_once __DIR__ . '/../views/jazz/artist-details.php';
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // public function editEventDetails()
    // {
    //     try {
    //         $eventId = isset($_POST['event_id']) ? htmlspecialchars($_POST['event_id']) : null;
    //         $newEventName = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : null;
    //         $newStartDate = isset($_POST['startDate']) ? htmlspecialchars($_POST['startDate']) : null;
    //         $newEndDate = isset($_POST['endDate']) ? htmlspecialchars($_POST['endDate']) : null;
    //         $newLocation = isset($_POST['location']) ? htmlspecialchars($_POST['location']) : null;
    //         $newPrice = isset($_POST['price']) ? htmlspecialchars($_POST['price']) : null;
    //         $newArtistName = isset($_POST['artistName']) ? htmlspecialchars($_POST['artistName']) : null;

    //         $currentEventDetails = $this->jazzservice->getEventDetails($eventId); // Pass $eventId to get specific event details
    //         $existingPicturePath = $currentEventDetails->getPicture();

    //         $uploadDirectory = '/img/EventImages/';
    //         $relativeUploadPath = $this->uploadImage($_FILES['image'] ?? null, $uploadDirectory);

    //         if ($relativeUploadPath === null) {
    //             $relativeUploadPath = $existingPicturePath;
    //         }

    //         // Use correct variable names in the method call
    //         $result = $this->jazzservice->editEventDetails($eventId, $newEventName, $newStartDate, $newEndDate, $newPrice, $relativeUploadPath, $newLocation, $newArtistName);

    //         if (!$result) {
    //             throw new Exception('Failed to edit Event Details.');
    //         }

    //         echo json_encode(['success' => true, 'message' => 'Event Details Edited Successfully.']);
    //     } catch (Exception $e) {
    //         header('HTTP/1.1 500 Internal Server Error');
    //         $errorMessage = strip_tags($e->getMessage()); // Remove HTML tags
    //         echo json_encode(['success' => false, 'message' => $errorMessage]);
    //     }
    //     exit;
    // }

    // public function addNewTimeSlot()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $eventId = htmlspecialchars($_POST['event_id'] ?? null);
    //         $date = htmlspecialchars($_POST['date'] ?? null);
    //         $quantity = htmlspecialchars($_POST['quantity'] ?? null);
    //         $language = htmlspecialchars($_POST['language'] ?? null);
    //         $time = htmlspecialchars($_POST['time'] ?? null);

    //         $newTicket = new Ticket();
    //         $newTicket->setEventId($eventId);
    //         $newTicket->setTicketDate($date);
    //         $newTicket->setQuantity($quantity);
    //         $newTicket->setTicketLanguage($language);
    //         $newTicket->setTicketTime($time);
    //         $newTicket->setState('Not Used');
    //         $newTicket->setTicketHash($this->generateTicketHash($eventId, $date, $time));

    //         $result = $this->jazzservice->addNewTimeSlot($newTicket);


    //         header('Content-Type: application/json');
    //         if ($result) {
    //             echo json_encode(['success' => true, 'message' => 'Timeslot added successfully.']);
    //         } else {
    //             echo json_encode(['success' => false, 'message' => 'Failed to add timeslot.']);
    //         }
    //         exit;
    //     }
    // }

    // public function removeTimeslot()
    // {
    //     try {
    //         $ticketID = htmlspecialchars($_POST['ticket_id'] ?? null);

    //         $result = $this->jazzservice->removeTimeslot($ticketID);
    //         header('Content-Type: application/json');
    //         if ($result) {
    //             echo json_encode(['success' => true, 'message' => 'Timeslot removed successfully.']);
    //         } else {
    //             echo json_encode(['success' => false, 'message' => 'Failed to revmove timeslot.']);
    //         }
    //         exit;
    //     } catch (Exception $e) {
    //         echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }

    private function generateTicketHash($eventId, $date, $time)
    {
        $toHash = $eventId . $date . $time . uniqid('', true);
        return hash('sha256', $toHash);
    }
    /*    private function getStructuredTickets($eventId)
    {
        $tickets = $this->jazzservice->getTickets($eventId);
        $structuredTickets = [];

        foreach ($tickets as $ticket) {
            $language = $ticket->getTicketLanguage();
            $date = $ticket->getTicketDate();
            $time = $ticket->getTicketTime();
            $quantity = $ticket->getQuantity();

            $structuredTickets[$language][$date][$time] = $quantity;
        }

        return $structuredTickets;
    }  */

    private function getUniqueTimes($structuredTickets)
    {
        $allTimes = [];

        foreach ($structuredTickets as $dates) {
            foreach ($dates as $times) {
                $allTimes = array_merge($allTimes, array_keys($times));
            }
        }

        $uniqueTimes = array_unique($allTimes);
        sort($uniqueTimes);

        return $uniqueTimes;
    }
}
