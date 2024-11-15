<?php

namespace model;

class JazzArtist implements \JsonSerializable
{
    private int $artist_id;
    private string $name;
    private ?string $description;
    private ?string $profile;
    private ?string $image1;
    private ?string $image2;
    private ?string $image3;
    private ?string $video;
    private ?string $album;

    public function jsonSerialize(): mixed
    {
        return [
            'artist_id' => $this->artist_id,
            'name' => $this->name,
            'description' => $this->description,
            'profile' => $this->profile,
            'image1' => $this->image1,
            'image2' => $this->image2,
            'image3' => $this->image3,
            'video' => $this->video,
            'album' => $this->album,
        ];
    }

    // Getters and Setters
    public function getArtistId(): int
    {
        return $this->artist_id;
    }

    public function setArtistId(int $artist_id): void
    {
        $this->artist_id = $artist_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getProfile(): ?string
    {
        return $this->profile;
    }

    public function setProfile(?string $profile): void
    {
        $this->profile = $profile;
    }

    public function getImage1(): ?string
    {
        return $this->image1;
    }

    public function setImage1(?string $image1): void
    {
        $this->image1 = $image1;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(?string $image2): void
    {
        $this->image2 = $image2;
    }

    public function getImage3(): ?string
    {
        return $this->image3;
    }

    public function setImage3(?string $image3): void
    {
        $this->image3 = $image3;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): void
    {
        $this->video = $video;
    }

    public function getAlbum(): ?string
    {
        return $this->album;
    }

    public function setAlbum(?string $album): void
    {
        $this->album = $album;
    }
}