<?php

namespace repositories;

use config\dbconfig;
use PDO;
use PDOException;
use model\JazzArtist;

require_once __DIR__ . '/../model/JazzArtist.php';

class JazzArtistRepository extends dbconfig
{
    public function getAllArtists()
    {
        try {
            $sql = 'SELECT * FROM JazzArtists';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, JazzArtist::class);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function getArtistById($artist_id)
    {
        try {
            $sql = 'SELECT * FROM JazzArtists WHERE artist_id = :artist_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':artist_id', $artist_id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, JazzArtist::class);
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    public function addArtist(JazzArtist $artist)
    {
        try {
            $sql = 'INSERT INTO JazzArtists (name, description, profile, image1, image2, image3, video, album) VALUES (:name, :description, :profile, :image1, :image2, :image3, :video, :album)';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute([
                ':name' => $artist->getName(),
                ':description' => $artist->getDescription(),
                ':profile' => $artist->getProfile(),
                ':image1' => $artist->getImage1(),
                ':image2' => $artist->getImage2(),
                ':image3' => $artist->getImage3(),
                ':video' => $artist->getVideo(),
                ':album' => $artist->getAlbum()
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function updateArtist(JazzArtist $artist)
    {
        try {
            $sql = 'UPDATE JazzArtists SET name = :name, description = :description, profile = :profile, image1 = :image1, image2 = :image2, image3 = :image3, video = :video, album = :album WHERE artist_id = :artist_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->execute([
                ':name' => $artist->getName(),
                ':description' => $artist->getDescription(),
                ':profile' => $artist->getProfile(),
                ':image1' => $artist->getImage1(),
                ':image2' => $artist->getImage2(),
                ':image3' => $artist->getImage3(),
                ':video' => $artist->getVideo(),
                ':album' => $artist->getAlbum(),
                ':artist_id' => $artist->getArtistId()
            ]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }

    public function deleteArtist($artist_id)
    {
        try {
            $sql = 'DELETE FROM JazzArtists WHERE artist_id = :artist_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':artist_id', $artist_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return 0;
        }
    }
}