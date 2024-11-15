<?php
namespace services;
use repositories\Jazzrepository;
require_once __DIR__.'/../repositories/jazzrepository.php';

class Jazzservice{
    private $jazzrepo;

    public function __construct()
    {
        $this->jazzrepo = new Jazzrepository();
    }

    public function getEventDetails()
    {
        return $this->jazzrepo->getEventdetails();
    }
    public function getTickets($eventId) {
        return $this->jazzrepo->getAvailableJazzEvents($eventId);
    }

    public function addNewTimeSlot($newTicket){
        $this->jazzrepo->addNewJazzTimeSlot($newTicket);
    }
    public function editEventDetails($eventId, $artistName, $eventDate, $eventTime, $price, $location, $picture){
        return $this->jazzrepo->editJazzEventDetails($eventId, $artistName, $eventDate, $eventTime, $price, $location, $picture);
    }
    public function existEvent($newEventName, $eventId){
        return $this->jazzrepo->existEvent($newEventName, $eventId);
    }
    public function removeTimeslot($ticketID){
        $this->jazzrepo->removeJazzEvent($ticketID);
    }

}
