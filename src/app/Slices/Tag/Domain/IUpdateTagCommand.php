<?php

namespace App\Slices\Tag\Domain;

class UpdateTagCommandInput
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}

interface IUpdateTagCommand
{
    public function execute(UpdateTagCommandInput $input): void;
}
