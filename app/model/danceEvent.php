<?php
namespace model;

class DanceEvent implements \JsonSerializable {
    private int $danceEventId;
    private string $venueId;
    private string $venue;
    private string $address;
    private string $dateTime;
    private float $price;
    private float $allDaysPrice;
    private float $oneDayPrice;
    private string $image;
    private array $artists;

    public function __construct(int $danceEventId, string $venueId, string $venue, string $address, string $dateTime, float $price, float $oneDayPrice, float $allDaysPrice, string $image, array $artists) {
        $this->danceEventId = $danceEventId;
        $this->venueId = $venueId;
        $this->venue = $venue;
        $this->address = $address;
        $this->dateTime = $dateTime;
        $this->price = $price;
        $this->allDaysPrice = $allDaysPrice;
        $this->oneDayPrice = $oneDayPrice;
        $this->image = $image;
        $this->artists = $artists;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->getDanceEventId(),
            'venueId' => $this->getVenueId(),
            'venue' => $this->getVenue(),
            'address' => $this->getAddress(),
            'dateTime' => $this->getDateTime(),
            'price' => $this->getPrice(),
            'allDaysPrice' => $this->getAllDaysPrice(),
            'oneDayPrice' => $this->getOneDayPrice(),
            'image' => $this->getImage(),
            'artists' => $this->getArtists()
        ];
    }

    public function getDanceEventId(): int {
        return $this->danceEventId;
    }

    public function getVenueId(): string {
        return $this->venueId;
    }

    public function getVenue(): string {
        return $this->venue;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getDateTime(): string {
        return $this->dateTime;
    }

    public function getFormattedDateTime(): string {
        return date("d/m/Y H:i", strtotime($this->dateTime));
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getAllDaysPrice(): float {
        return $this->allDaysPrice;
    }

    public function getOneDayPrice(): float {
        return $this->oneDayPrice;
    }

    public function getImage(): string {
        return $this->image;
    }

    public function getArtists(): array {
        return $this->artists;
    }

    public function getArtistsAsString(): string {
        $artists = "";
        if (empty($this->artists)) {
            return "No artists";
        }

        foreach ($this->artists as $artist) {
            $artists .= $artist->getName() . ", ";
        }
        return rtrim($artists, ", ");
    }
}