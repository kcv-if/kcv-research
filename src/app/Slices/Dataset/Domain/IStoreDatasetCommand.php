<?php

namespace App\Slices\Dataset\Domain;

use DateTime;

class StoreDatasetCommandInput
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $description,
        public string $downloadLink,
        public string $status,
        public DateTime $createdAt
    ) {
    }
}

interface IStoreDatasetCommand
{
    public function execute(StoreDatasetCommandInput $input): void;
}
