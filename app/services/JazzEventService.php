<?php

namespace services;

use repositories\JazzEventRepository;
use model\JazzEvent;
use Exception;

require_once __DIR__ . '/../repositories/JazzEventRepository.php';

class JazzEventService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new JazzEventRepository();
    }

    public function getAllEvents()
    {
        try {
            return $this->repository->getAllEvents();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getEventById($event_id)
    {
        try {
            return $this->repository->getEventById($event_id);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    public function addEvent(JazzEvent $event)
    {
        try {
            return $this->repository->addEvent($event);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function updateEvent(JazzEvent $event)
    {
        try {
            return $this->repository->updateEvent($event);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function deleteEvent($event_id)
    {
        try {
            return $this->repository->deleteEvent($event_id);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function addArtistToEvent($event_id, $artist_id)
    {
        try {
            return $this->repository->addArtistToEvent($event_id, $artist_id);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function getArtistsByEvent($event_id)
    {
        try {
            return $this->repository->getArtistsByEvent($event_id);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function removeArtistsFromEvent($event_id)
    {
        try {
            return $this->repository->removeArtistsFromEvent($event_id);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function getEventsByDate($date)
    {
        try {
            return $this->repository->getEventsByDate($date);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
}
