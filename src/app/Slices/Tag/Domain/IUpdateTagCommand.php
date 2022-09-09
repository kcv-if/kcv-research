<?php

namespace App\Slices\Tag\Domain;

use DateTime;

class UpdateTagCommandInput
{
    public function __construct(
        public int $id,
        public string $name,
        public DateTime $updatedAt
    ) {
    }
}

interface IUpdateTagCommand
{
    public function execute(UpdateTagCommandInput $input): void;
}
