<?php

namespace App\Slices\Publication\Domain;

use DateTime;

class GetByUuidPublicationQueryOutput
{
    public function __construct(
        public bool $success,
        public int $id,
        public string $uuid,
        public string $name,
        public string $excerpt,
        public string $abstract,
        public string $downloadLink,
        public string $status,
        public ?DateTime $createdAt,
        public ?DateTime $updatedAt
    ) {
    }
}

interface IGetByUuidPublicationQuery
{
    public function execute(string $uuid): GetByUuidPublicationQueryOutput;
}
