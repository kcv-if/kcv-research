<?php

namespace App\Slices\Publication\Domain;

use DateTime;

class StorePublicationCommandInput
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $excerpt,
        public string $abstract,
        public string $downloadLink,
        public string $status,
        public DateTime $createdAt
    ) {
    }
}

interface IStorePublicationCommand
{
    public function execute(StorePublicationCommandInput $input): void;
}
