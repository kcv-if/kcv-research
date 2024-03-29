<?php

namespace App\Slices\Tag\Domain;

class Tag
{
    public function __construct(
        private int $id,
        private string $uuid,
        private string $name,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
