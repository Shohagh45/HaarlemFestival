<?php

namespace services;

use repositories\JazzVenueRepository;
use model\JazzVenue;
use Exception;

require_once __DIR__ . '/../repositories/JazzVenueRepository.php';

class JazzVenueService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new JazzVenueRepository();
    }

    public function getAllVenues()
    {
        try {
            return $this->repository->getAllVenues();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getVenueById($venue_id)
    {
        try {
            return $this->repository->getVenueById($venue_id);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    public function addVenue(JazzVenue $venue)
    {
        try {
            return $this->repository->addVenue($venue);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function updateVenue(JazzVenue $venue)
    {
        try {
            return $this->repository->updateVenue($venue);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function deleteVenue($venue_id)
    {
        try {
            return $this->repository->deleteVenue($venue_id);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}