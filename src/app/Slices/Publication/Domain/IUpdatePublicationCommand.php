<?php

namespace App\Slices\Publication\Domain;

use DateTime;

class UpdatePublicationCommandInput
{
    public function __construct(
        public int $id,
        public string $name,
        public string $excerpt,
        public string $abstract,
        public string $downloadLink,
        public string $status,
        public DateTime $updatedAt
    ) {
    }
}

interface IUpdatePublicationCommand
{
    public function execute(UpdatePublicationCommandInput $input): void;
}
