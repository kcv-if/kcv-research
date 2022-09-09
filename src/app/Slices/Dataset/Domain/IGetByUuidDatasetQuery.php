<?php

namespace App\Slices\Dataset\Domain;

use DateTime;

class GetByUuidDatasetQueryOutput
{
    public function __construct(
        public bool $success,
        public int $id,
        public string $uuid,
        public string $name,
        public string $description,
        public string $downloadLink,
        public string $status,
        public ?DateTime $createdAt,
        public ?DateTime $updatedAt
    ) {
    }
}

interface IGetByUuidDatasetQuery
{
    public function execute(string $uuid): GetByUuidDatasetQueryOutput;
}
