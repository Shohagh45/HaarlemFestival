<?php

namespace services;

use repositories\AdminRepository; 
require_once __DIR__ . '/../repositories/AdminRepository.php'; 

class AdminService {
    private $adminRepository;

    public function __construct() {
        $this->adminRepository = new AdminRepository(); 
    }

    public function getAllUsers() {
        return $this->adminRepository->getAllUsers();
    }

    public function filterUsers($username, $role) {
        return $this->adminRepository->filterUsers($username, $role);
    }
}