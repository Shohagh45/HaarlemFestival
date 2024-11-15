<?php

namespace controllers;

use services\JazzEventService;
use model\JazzEvent;
use services\JazzEventArtistService;

require_once __DIR__ . '/../services/JazzEventArtistService.php';

class JazzEventController
{
    private $eventService;
    private $eventArtistService;

    public function __construct()
    {
        $this->eventService = new JazzEventService();
        $this->eventArtistService = new JazzEventArtistService();
    }

    public function index()
    {
        try {
            $events = $this->eventService->getAllEvents();
            require_once __DIR__ . '/../views/jazz_events/index.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $event = $this->eventService->getEventById($id);
            $artists = $this->eventService->getArtistsByEvent($id);
            require_once __DIR__ . '/../views/jazz_events/show.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function create()
    {
        try {
            require_once __DIR__ . '/../views/jazz_events/create.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function store()
    {
        try {
            $event = new JazzEvent();
            $event->setDate($_POST['date']);

            $event->setImage($this->uploadImage('image'));

            $event->setVenueId($_POST['venue_id']);
            $event->setOnedayprice($_POST['onedayprice']);
            $event->setAlldayprice($_POST['alldayprice']);
            $event_id = $this->eventService->addEvent($event);

            foreach ($_POST['artist_ids'] as $artist_id) {
                $this->eventArtistService->addArtistToEvent($event_id, $artist_id);
            }

            $this->redirectBack();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $event = $this->eventService->getEventById($id);
            require_once __DIR__ . '/../views/jazz_events/edit.php';
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function update()
    {
        try {
            $event = $this->eventService->getEventById($_POST['id']);
            $event->setDate($_POST['date']);

            $event->setImage($this->uploadImage('image', $event->getImage()));

            $event->setVenueId($_POST['venue_id']);
            $event->setOnedayprice($_POST['onedayprice']);
            $event->setAlldayprice($_POST['alldayprice']);
            $this->eventService->updateEvent($event);

            $event_id = $event->getEventId();
            $this->eventService->removeArtistsFromEvent($event_id);

            foreach ($_POST['artist_ids'] as $artist_id) {
                $this->eventArtistService->addArtistToEvent($event_id, $artist_id);
            }

            $this->redirectBack();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function delete()
    {
        try {
            $this->eventService->deleteEvent($_POST['id']);
            $this->redirectBack();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function addArtistToEvent($event_id, $artist_id)
    {
        try {
            $this->eventService->addArtistToEvent($event_id, $artist_id);
            header('Location: /jazz_events/' . $event_id);
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

    public function getEventsByDate()
    {
        try {
            $rawData = file_get_contents('php://input');
            $postData = json_decode($rawData, true);
            
            if (isset($postData['date'])) {
                $date = $postData['date'];

                $events = $this->eventService->getEventsByDate($date);

                header('Content-Type: application/json');
                echo json_encode($events);
            } else {
                error_log("Date parameter is missing");
                header('HTTP/1.1 400 Bad Request');
                echo json_encode(['error' => 'Date parameter is required']);
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
