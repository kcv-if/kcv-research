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
        private DateTime $createdAt
    ) {
    }
}
