<?php

namespace App\Slices\Dataset\Domain;

use DateTime;

class GetAllDatasetQueryOutputItem
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $name,
        public string $description,
        public string $downloadLink,
        public string $status,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {
    }
}

interface IGetAllDatasetQuery
{
    public function execute(): array;
}
