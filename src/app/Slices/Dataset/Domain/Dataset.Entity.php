<?php

namespace App\Slices\Dataset\Domain;

use DateTime;

class Dataset
{
    public function __construct(
        private int $id,
        private string $uuid,
        private string $name,
        private string $description,
        private string $downloadLink,
        private string $status,
        private array $authors = [],
        private array $reviews = [],
        private array $publications = [],
        private array $tags = [],
        private DateTime $createdAt,
        private DateTime $updatedAt
    ) {
    }
}
