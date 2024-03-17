<?php

namespace controllers;

use services\Myprogramservice;
use services\registerservice;
use services\ticketservice;
use controllers\NavigationController;
//call the user service to check update user data 

require_once __DIR__ . '/../services/myprogramservice.php';
require_once __DIR__ . '/../services/registerservice.php';
require_once __DIR__ . '/../config/constant-paths.php';
require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../services/ticketservice.php';


class Myprogramcontroller
{
    private $navigationController;
    private $ticketservice;
    private $myProgramService;
    private $userService;

    public function __construct()
    {
        $this->myProgramService = new Myprogramservice();
        $this->ticketservice = new ticketservice();
        $this->navigationController = new NavigationController();
        $this->userService = new registerservice();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    function show()
    {
        $this->navigationController->displayHeader();
        $structuredTickets = $this->structureTicketsWithImages();
        $uniqueTimes = $this->getUniqueTimes($structuredTickets);
        require_once __DIR__ . '/../views/my-program/list-view.php';
    }

    function createReservation()
    {
        //creates a shopping cart if it does not exist in the session
        $this->createShoppingCart();

        //decodes session data 
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);

        //holds user info
        $userInfo = [
            'firstName' => $input['firstName'] ?? '',
            'lastName' => $input['lastName'] ?? '',
            'address' => $input['address'] ?? '',
            'phoneNumber' => $input['phoneNumber'] ?? '',
            'email' => $input['email'] ?? ''
        ];

        //updates the user object in the session
        $_SESSION['user']['firstName'] = $userInfo['firstName'];
        $_SESSION['user']['lastName'] = $userInfo['lastName'];
        $_SESSION['user']['address'] = $userInfo['address'];
        $_SESSION['user']['phoneNumber'] = $userInfo['phoneNumber'];
        $_SESSION['user']['email'] = $userInfo['email'];

        $this->updateUserInfo();

        $ticketInfo = [
            'ticketId' => $input['ticketId'] ?? '',
            'eventId' => $input['eventId'] ?? '',
            'ticketPrice' => $input['ticketPrice'] ?? '',
            'quantity' => $input['quantity'] ?? '',
            'ticketDate' => $input['ticketDate'] ?? '',
            'ticketTime' => $input['ticketTime'] ?? '',
            'user' => $userInfo
        ];

        switch ($ticketInfo['eventId']) {
            case EVENT_ID_DANCE:
            case EVENT_ID_JAZZ:
                $ticketInfo['artistName'] = $input['artistName'] ?? '';
                break;
            case EVENT_ID_RESTAURANT:
                $ticketInfo['restaurantName'] = $input['restaurantName'] ?? '';
                break;
            case EVENT_ID_HISTORY:
                $ticketInfo['ticketLanguage'] = $input['ticketLanguage'] ?? '';
                break;
            default:
                break;
        }

        foreach ($_SESSION['shopping_cart'] as $item) {
            if (
                $item['ticketId'] == $ticketInfo['ticketId'] &&
                $item['eventId'] == $ticketInfo['eventId'] &&
                $item['ticketDate'] == $ticketInfo['ticketDate'] &&
                $item['ticketTime'] == $ticketInfo['ticketTime']
            ) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'This ticket is already in your shopping cart.',
                ]);
                exit;
            }
        }

        $_SESSION['shopping_cart'][] = $ticketInfo;

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Reservation successfully created!',
        ]);
        exit;
    }

    function updateUserInfo(){
        
        $userInfo = [
            'firstName' => $_SESSION['user']['firstName'] ?? '',
            'lastName' => $_SESSION['user']['lastName'] ?? '',
            'address' => $_SESSION['user']['address'] ?? '',
            'phoneNumber' => $_SESSION['user']['phoneNumber'] ?? '',
            'email' => $_SESSION['user']['email'] ?? ''
        ];
    

        $userEmail = $userInfo['email'];
        $userExists = $this->userService->email_exists($userEmail);
    
        if ($userExists) {
            $this->userService->updateUser($userInfo); 
        }
    }
    
    function createShoppingCart()
    {
        if (!isset ($_SESSION['shopping_cart'])) {
            $_SESSION['shopping_cart'] = array();
        }
    }


    function addToItemQuantity($ticketId, $eventId, $amountToAdd)
    {
        foreach ($_SESSION['shopping_cart'] as &$item) {
            if ($item['ticketId'] == $ticketId && $item['eventId'] == $eventId) {
                $item['quantity'] += $amountToAdd;
                break;
            }
        }
        unset($item);
    }

    function subtractFromItemQuantity($ticketId, $eventId, $amountToSubtract)
    {
        foreach ($_SESSION['shopping_cart'] as &$item) {
            if ($item['ticketId'] == $ticketId && $item['eventId'] == $eventId) {
                $item['quantity'] -= $amountToSubtract;
                if ($item['quantity'] < 1) {
                    $item['quantity'] = 1;
                }
                break;
            }
        }
        unset($item);
    }

    function deleteItemFromCart($ticketId, $eventId)
    {
        foreach ($_SESSION['shopping_cart'] as $key => $item) {
            if ($item['ticketId'] == $ticketId && $item['eventId'] == $eventId) {
                unset($_SESSION['shopping_cart'][$key]);
                $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
                break;
            }
        }
    }



    private function structureTicketsWithImages()
    {
        $structuredTickets = [];
        foreach ($_SESSION['shopping_cart'] as $ticket) {
            $eventId = $ticket['eventId'];
            if (!array_key_exists($eventId, $structuredTickets)) {
                $eventDetails = $this->ticketservice->getEventDetails($eventId);
                $structuredTickets[$eventId] = [
                    'tickets' => [],
                    'image' => $eventDetails['picture'] ?? null,
                    'event_name' => $eventDetails['name'] ?? null,
                    'location' => $eventDetails['location'] ?? null,
                    'totalPrice' => 0 
                ];
            }
            $ticketTotalPrice = $ticket['quantity'] * $ticket['ticketPrice'];
            $structuredTickets[$eventId]['totalPrice'] += $ticketTotalPrice;
            $ticket['totalPrice'] = $ticketTotalPrice;
            $structuredTickets[$eventId]['tickets'][] = $ticket;
        }
        return $structuredTickets;
    }
    


    private function getUniqueTimes($structuredTickets)
    {
        $allTimes = [];
    
        foreach ($structuredTickets as $event) {
            foreach ($event['tickets'] as $ticket) {
                if (isset($ticket['ticketTime']) && is_string($ticket['ticketTime'])) {
                    $allTimes[] = $ticket['ticketTime'];
                }
            }
        }
    
        $uniqueTimes = array_unique($allTimes);
        sort($uniqueTimes);
    
        return $uniqueTimes;
    }
    

}
