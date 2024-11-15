<?php

namespace repositories;

use config\dbconfig;
use model\JazzArtist;
use PDO;
use PDOException;
use model\JazzEvent;

require_once __DIR__ . '/../model/JazzEvent.php';

class JazzEventRepository extends dbconfig
{
    public function getAllEvents()
    {
        try {
            $sql = 'SELECT * FROM JazzEvents';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_CLASS, JazzEvent::class);

            foreach ($events as $event) {
                $event->setArtistIds($this->getArtistIdsByEvent($event->getEventId()));
            }

            return $events;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getEventById($event_id)
    {
        try {
            $sql = 'SELECT * FROM JazzEvents WHERE event_id = :event_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, JazzEvent::class);
            $event = $stmt->fetch();

            if ($event) {
                $event->setArtistIds($this->getArtistIdsByEvent($event->getEventId()));
            }

            return $event;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    public function addEvent(JazzEvent $event)
    {
        try {
            $sql = 'INSERT INTO JazzEvents (date, image, venue_id, onedayprice, alldayprice) VALUES (:date, :image, :venue_id, :onedayprice, :alldayprice)';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute([
                ':date' => $event->getDate(),
                ':image' => $event->getImage(),
                ':venue_id' => $event->getVenueId(),
                ':onedayprice' => $event->getOnedayprice(),
                ':alldayprice' => $event->getAlldayprice()
            ]);
            return $this->getConnection()->lastInsertId();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function updateEvent(JazzEvent $event)
    {
        try {
            $sql = 'UPDATE JazzEvents SET date = :date, image = :image, venue_id = :venue_id, onedayprice = :onedayprice, alldayprice = :alldayprice WHERE event_id = :event_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute([
                ':date' => $event->getDate(),
                ':image' => $event->getImage(),
                ':venue_id' => $event->getVenueId(),
                ':onedayprice' => $event->getOnedayprice(),
                ':alldayprice' => $event->getAlldayprice(),
                ':event_id' => $event->getEventId()
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function deleteEvent($event_id)
    {
        try {
            $sql = 'DELETE FROM JazzEvents WHERE event_id = :event_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function addArtistToEvent($event_id, $artist_id)
    {
        try {
            $sql = 'INSERT INTO JazzEventArtists (event_id, artist_id) VALUES (:event_id, :artist_id)';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute([
                ':event_id' => $event_id,
                ':artist_id' => $artist_id
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function getArtistsByEvent($event_id)
    {
        try {
            $sql = 'SELECT a.* FROM JazzArtists a INNER JOIN JazzEventArtists ea ON a.artist_id = ea.artist_id WHERE ea.event_id = :event_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, JazzArtist::class);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getArtistIdsByEvent($event_id)
    {
        try {
            $sql = 'SELECT artist_id FROM JazzEventArtists WHERE event_id = :event_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getLastInsertId()
    {
        try {
            return $this->getConnection()->lastInsertId();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function removeArtistsFromEvent($event_id)
    {
        try {
            $sql = 'DELETE FROM JazzEventArtists WHERE event_id = :event_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function getEventsByDate($date)
    {
        try {
            $sql = 'SELECT e.*, v.location, v.name as venueName FROM JazzEvents e JOIN JazzVenues v ON e.venue_id = v.venue_id WHERE DATE(e.date) = :date';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, JazzEvent::class);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
}