<?php

namespace model;

class JazzEventArtist
{
    private int $id;
    private int $event_id;
    private int $artist_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEventId(): int
    {
        return $this->event_id;
    }

    public function setEventId(int $event_id): void
    {
        $this->event_id = $event_id;
    }

    public function getArtistId(): int
    {
        return $this->artist_id;
    }

    public function setArtistId(int $artist_id): void
    {
        $this->artist_id = $artist_id;
    }
}
