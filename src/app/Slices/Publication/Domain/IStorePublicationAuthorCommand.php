<?php

namespace App\Slices\Publication\Domain;

class StorePublicationAuthorCommandInput
{
    public function __construct(
        public int $user_id,
        public int $publication_id,
    ) {
    }
}

interface IStorePublicationAuthorCommand
{
    public function execute(StorePublicationAuthorCommandInput $input): void;
}
