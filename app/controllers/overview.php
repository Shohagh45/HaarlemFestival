<?php

namespace controllers;

use controllers\Navigationcontroller;
use services\JazzArtistService;

require_once __DIR__ . '/../controllers/navigationcontroller.php';
require_once __DIR__ . '/../services/JazzArtistService.php';

class overview
{
    private $navigationController;
    private $artistService;

    public function __construct()
    {
        $this->navigationController = new Navigationcontroller();
        $this->artistService = new JazzArtistService();
    }

    public function show()
    {
        $navigationController = $this->navigationController->displayHeader();
        $artists = $this->artistService->getAllArtists();
        require_once '../views/general_views/overview.php';
    }

    public function editContent()
    {
        require_once __DIR__ . '/../views/admin/page-managment/editHome.php';
    }
}