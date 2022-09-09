<?php

namespace App\Slices\User\Domain;

use DateTime;

class User
{
    public function __construct(
        private int $id,
        private string $uuid,
        private string $role,
        private string $name,
        private string $email,
        private string $password,
        private string $telephone,
        private array $publications = [],
        private array $publicationReviews = [],
        private array $datasets = [],
        private array $datasetReviews = [],
        private ?DateTime $createdAt
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
