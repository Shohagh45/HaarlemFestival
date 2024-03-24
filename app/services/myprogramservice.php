<?php

namespace services;
use repositories\Myprogramrepository;
require_once __DIR__ . '/../repositories/myprogramrepository.php';

class Myprogramservice
{
    private $myprogramRepo;
 
    public function __construct() {
        $this->myprogramRepo = new Myprogramrepository();
    }

    function processOrder($userId, $cart, $paymentStatus){
        return $this->myprogramRepo->processOrder($userId, $cart, $paymentStatus);
    }

    function createOrder($userId, $totalPrice, $paymentStatus){
        return $this->myprogramRepo->createOrder($userId, $totalPrice, $paymentStatus);
    }

    function updateTicketQuantity($ticketId, $quantityPurchased){
        return $this->myprogramRepo->updateTicketQuantity($ticketId, $quantityPurchased);
    }


    function createOrderItem($orderId, $userId, $item){
        return $this->myprogramRepo->createOrderItem($orderId, $userId, $item);
    }

    function getOrderItemsByUser($userID){
        return $this->myprogramRepo->getOrderItemsByUser($userID);
    }

}