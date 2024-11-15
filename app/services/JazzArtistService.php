<?php

namespace services;

use repositories\JazzArtistRepository;
use model\JazzArtist;
use Exception;

require_once __DIR__ . '/../repositories/JazzArtistRepository.php';

class JazzArtistService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new JazzArtistRepository();
    }

    public function getAllArtists()
    {
        try {
            return $this->repository->getAllArtists();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getArtistById($artist_id)
    {
        try {
            return $this->repository->getArtistById($artist_id);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    public function addArtist(JazzArtist $artist)
    {
        try {
            return $this->repository->addArtist($artist);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function updateArtist(JazzArtist $artist)
    {
        try {
            return $this->repository->updateArtist($artist);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function deleteArtist($artist_id)
    {
        try {
            return $this->repository->deleteArtist($artist_id);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }
}