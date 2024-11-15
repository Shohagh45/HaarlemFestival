<?php
namespace model;
use JsonSerializable;

class Jazz implements \JsonSerializable{

    private $artistName;
    private $time;
    private $location;
    private $price;
    private $reserved;
    
    public function getArtistName() {
        return $this->artistName;
    }

    public function getTime() {
        return $this->time;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getPrice() {
        return $this->price;
    }

    public function isReserved() {
        return $this->reserved;
    }

  
    public function setArtistName($artistName) {
        $this->artistName = $artistName;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function setPrice($price) {
        $this->price = $price;
    }
    public function jsonSerialize():mixed {
        return [
            'artistName' => $this->artistName,
            'time' => $this->time,
            'location' => $this->location,
            'price' => $this->price,
            'reserved' => $this->reserved
        ];
    }
}