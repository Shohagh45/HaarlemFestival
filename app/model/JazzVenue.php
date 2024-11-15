<?php

namespace model;

class JazzVenue implements \JsonSerializable
{
    private int $venue_id;
    private string $name;
    private string $location;
    private ?string $picture;

    public function jsonSerialize(): mixed
    {
        return [
            'venue_id' => $this->venue_id,
            'name' => $this->name,
            'location' => $this->location,
            'picture' => $this->picture,
        ];
    }

    // Getters and Setters
    public function getVenueId(): int
    {
        return $this->venue_id;
    }

    public function setVenueId(int $venue_id): void
    {
        $this->venue_id = $venue_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): void
    {
        $this->picture = $picture;
    }
}