<?php

namespace App\Slices\Publication\Domain;

use DateTime;

class Publication
{
    public function __construct(
        private int $id,
        private string $uuid,
        private string $name,
        private string $excerpt,
        private string $abstract,
        private string $downloadLink,
        private string $status,
        private array $authors = [],
        private array $reviews = [],
        private array $datasets = [],
        private array $tags = [],
        private DateTime $createdAt,
        private ?DateTime $updatedAt
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExcerpt(): string
    {
        return $this->excerpt;
    }

    public function getAbstract(): string
    {
        return $this->abstract;
    }

    public function getDownloadLink(): string
    {
        return $this->downloadLink;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
