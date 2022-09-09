<?php

namespace App\Slices\Publication\Domain;

class StorePublicationTagCommandInput
{
    public function __construct(
        public int $publication_id,
        public int $tag_id,
    ) {
    }
}

interface IStorePublicationTagCommand
{
    public function execute(StorePublicationTagCommandInput $input): void;
}
