<?php

namespace App\Slices\Publication\Domain;

use DateTime;

class GetAllPublicationQueryOutputItem
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $name,
        public string $excerpt,
        public string $abstract,
        public string $downloadLink,
        public string $status,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {
    }
}

interface IGetAllPublicationQuery
{
    public function execute(): array;
}
