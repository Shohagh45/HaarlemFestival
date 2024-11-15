<?php

namespace model;

class JazzEvent implements \JsonSerializable
{
    private int $event_id;
    private string $date;
    private ?string $image;
    private int $venue_id;
    private float $onedayprice;
    private float $alldayprice;
    private array $artist_ids = [];
    private ?string $venueName = null;
    private ?string $location = null;

    public function jsonSerialize(): mixed
    {
        return [
            'event_id' => $this->event_id,
            'date' => $this->date,
            'image' => $this->image,
            'venue_id' => $this->venue_id,
            'onedayprice' => $this->onedayprice,
            'alldayprice' => $this->alldayprice,
            'venueName' => $this->venueName,
            'location' => $this->location,
        ];
    }

    // Getters and Setters
    public function getEventId(): int
    {
        return $this->event_id;
    }

    public function setEventId(int $event_id): void
    {
        $this->event_id = $event_id;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getVenueId(): int
    {
        return $this->venue_id;
    }

    public function setVenueId(int $venue_id): void
    {
        $this->venue_id = $venue_id;
    }

    public function getOnedayprice(): float
    {
        return $this->onedayprice;
    }

    public function setOnedayprice(float $onedayprice): void
    {
        $this->onedayprice = $onedayprice;
    }

    public function getAlldayprice(): float
    {
        return $this->alldayprice;
    }

    public function setAlldayprice(float $alldayprice): void
    {
        $this->alldayprice = $alldayprice;
    }

    public function getArtistIds(): array
    {
        return $this->artist_ids;
    }

    public function setArtistIds(array $artist_ids): void
    {
        $this->artist_ids = $artist_ids;
    }

    public function getVenueName(): ?string
    {
        return $this->venueName;
    }

    public function setVenueName(?string $venueName): void
    {
        $this->venueName = $venueName;
    }
    
    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): void
    {
        $this->location = $location;
    }
}