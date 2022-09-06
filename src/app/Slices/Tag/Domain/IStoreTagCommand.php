<?php

namespace App\Slices\Tag\Domain;

class StoreTagCommandInput
{
    public function __construct(
        public string $uuid,
        public string $name,
    ) {
    }
}

interface IStoreTagCommand
{
    public function execute(StoreTagCommandInput $input): bool;
}
