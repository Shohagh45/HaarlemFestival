<?php

namespace services;

use repositories\JazzEventArtistRepository;
use model\JazzEventArtist;
use Exception;

require_once __DIR__ . '/../repositories/JazzEventArtistRepository.php';

class JazzEventArtistService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new JazzEventArtistRepository();
    }

    public function addArtistToEvent(int $event_id, int $artist_id): bool
    {
        try {
            $jazzEventArtist = new JazzEventArtist();
            $jazzEventArtist->setEventId($event_id);
            $jazzEventArtist->setArtistId($artist_id);
            
            return $this->repository->addArtistToEvent($jazzEventArtist);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function getArtistsByEvent(int $event_id): array
    {
        try {
            return $this->repository->getArtistsByEvent($event_id);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
}