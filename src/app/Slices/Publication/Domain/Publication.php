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
        private DateTime $updatedAt
    ) {
    }
}
