<?php

namespace repositories;

use PDO;
use PDOException;
use model\JazzEventArtist;
use config\dbconfig;

require_once __DIR__ . '/../model/JazzEventArtist.php';

class JazzEventArtistRepository extends dbconfig
{
    public function addArtistToEvent(JazzEventArtist $jazzEventArtist): bool
    {
        $sql = 'INSERT INTO JazzEventArtists (event_id, artist_id) VALUES (:event_id, :artist_id)';

        try {
            $stmt = $this->getConnection()->prepare($sql);
            $eventId = $jazzEventArtist->getEventId();
            $artistId = $jazzEventArtist->getArtistId();

            $stmt->bindParam(':event_id', $eventId, PDO::PARAM_INT);
            $stmt->bindParam(':artist_id', $artistId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getArtistsByEvent(int $event_id): array
    {
        $sql = 'SELECT artist_id FROM JazzEventArtists WHERE event_id = :event_id';

        try {
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}