<?php

namespace controllers;

use services\ResetPasswordService;
require_once __DIR__ . '/../services/resetpasswordservice.php';

class resetpasswordcontroller
{
    private $resetpasswordService;
  
    public function __construct() {
        $this->resetpasswordService = new ResetPasswordService();
    }

    public function showResetPasswordForm()
    {
        require_once '../views/general_views/reset-password.php';
    }

    public function showNewPasswordForm()
    {
        require_once '../views/general_views/new-password.php';
    }

    public function successfulNewPassword ()
    {
        require_once'../views/general_views/password-updated.php';
    }

    public function showLinkSuccessfullySent()
    {
        require_once'../views/general_views/reset-link-sent';

    }

    public function resetpasswordAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars($_POST["email"]);
        }
    }

    public function checkToken() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $email = htmlspecialchars($_GET["token"]);
        }
        
    }
}