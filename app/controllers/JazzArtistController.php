<?php

namespace controllers;

use services\JazzArtistService;
use model\JazzArtist;

class JazzArtistController
{
    private $service;

    public function __construct()
    {
        $this->service = new JazzArtistService();
    }

    public function index()
    {
        try {
            $artists = $this->service->getAllArtists();
            require_once __DIR__ . '/../views/jazz_artists/index.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $artist = $this->service->getArtistById($id);
            require_once __DIR__ . '/../views/jazz_artists/show.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function create()
    {
        try {
            require_once __DIR__ . '/../views/jazz_artists/create.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function store()
    {
        try {
            $artist = new JazzArtist();
            $artist->setName($_POST['name']);
            $artist->setDescription($_POST['description']);

            // Handle file uploads
            $artist->setProfile($this->uploadImage('profile'));
            $artist->setImage1($this->uploadImage('image1'));
            $artist->setImage2($this->uploadImage('image2'));
            $artist->setImage3($this->uploadImage('image3'));

            $artist->setVideo($_POST['video']);
            $artist->setAlbum($_POST['album']);

            $this->service->addArtist($artist);
            $this->redirectBack();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $artist = $this->service->getArtistById($id);
            require_once __DIR__ . '/../views/jazz_artists/edit.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function update()
    {
        try {
            $artist = $this->service->getArtistById($_POST['id']);
            $artist->setName($_POST['name']);
            $artist->setDescription($_POST['description']);

            // Handle file uploads
            $artist->setProfile($this->uploadImage('profile', $artist->getProfile()));
            $artist->setImage1($this->uploadImage('image1', $artist->getImage1()));
            $artist->setImage2($this->uploadImage('image2', $artist->getImage2()));
            $artist->setImage3($this->uploadImage('image3', $artist->getImage3()));

            $artist->setVideo($_POST['video']);
            $artist->setAlbum($_POST['album']);

            $this->service->updateArtist($artist);
            $this->redirectBack();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function delete()
    {
        try {
            $this->service->deleteArtist($_POST['id']);
            $this->redirectBack();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    private function uploadImage($fieldName, $existingPath = null)
    {
        try {
            if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES[$fieldName]['tmp_name'];
                $fileName = $_FILES[$fieldName]['name'];
                $fileSize = $_FILES[$fieldName]['size'];
                $fileType = $_FILES[$fieldName]['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

                // Directory where you want to save the uploaded files
                $uploadFileDir = __DIR__ . '/../public/img/';
                $destPath = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    return '/img/' . $newFileName;
                }
            }
            return $existingPath;
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return $existingPath;
        }
    }

    private function redirectBack()
    {
        try {
            $referrer = $_SERVER['HTTP_REFERER'] ?? '/';
            header('Location: ' . $referrer);
            exit;
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}