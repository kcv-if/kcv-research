<?php

namespace App\Slices\Dataset\Domain;

use DateTime;

class UpdateDatasetCommandInput
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $downloadLink,
        public string $status,
        public DateTime $updatedAt
    ) {
    }
}

interface IUpdateDatasetCommand
{
    public function execute(UpdateDatasetCommandInput $input): void;
}
