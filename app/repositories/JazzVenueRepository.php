<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use model\JazzVenue;

require_once __DIR__ . '/../model/JazzVenue.php';

class JazzVenueRepository extends dbconfig
{
    public function getAllVenues()
    {
        try {
            $sql = 'SELECT * FROM JazzVenues';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, JazzVenue::class);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getVenueById($venue_id)
    {
        try {
            $sql = 'SELECT * FROM JazzVenues WHERE venue_id = :venue_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':venue_id', $venue_id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, JazzVenue::class);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    public function addVenue(JazzVenue $venue)
    {
        try {
            $sql = 'INSERT INTO JazzVenues (name, location, picture) VALUES (:name, :location, :picture)';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute([
                ':name' => $venue->getName(),
                ':location' => $venue->getLocation(),
                ':picture' => $venue->getPicture()
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function updateVenue(JazzVenue $venue)
    {
        try {
            $sql = 'UPDATE JazzVenues SET name = :name, location = :location, picture = :picture WHERE venue_id = :venue_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute([
                ':name' => $venue->getName(),
                ':location' => $venue->getLocation(),
                ':picture' => $venue->getPicture(),
                ':venue_id' => $venue->getVenueId()
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function deleteVenue($venue_id)
    {
        try {
            $sql = 'DELETE FROM JazzVenues WHERE venue_id = :venue_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':venue_id', $venue_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }
}