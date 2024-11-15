<?php

namespace controllers;

use services\JazzVenueService;
use model\JazzVenue;

class JazzVenueController
{
    private $service;

    public function __construct()
    {
        $this->service = new JazzVenueService();
    }

    public function index()
    {
        try {
            $venues = $this->service->getAllVenues();
            require_once __DIR__ . '/../views/jazz_venues/index.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $venue = $this->service->getVenueById($id);
            require_once __DIR__ . '/../views/jazz_venues/show.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function create()
    {
        try {
            require_once __DIR__ . '/../views/jazz_venues/create.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function store()
    {
        try {
            $venue = new JazzVenue();
            $venue->setName($_POST['name']);
            $venue->setLocation($_POST['location']);

            $venue->setPicture($this->uploadImage('picture'));

            $this->service->addVenue($venue);
            $this->redirectBack();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $venue = $this->service->getVenueById($id);
            require_once __DIR__ . '/../views/jazz_venues/edit.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function update()
    {
        try {
            $venue = $this->service->getVenueById($_POST['id']);
            $venue->setName($_POST['name']);
            $venue->setLocation($_POST['location']);

            $venue->setPicture($this->uploadImage('picture', $venue->getPicture()));

            $this->service->updateVenue($venue);
            $this->redirectBack();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function delete()
    {
        try {
            $this->service->deleteVenue($_POST['id']);
            $this->redirectBack();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
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
}