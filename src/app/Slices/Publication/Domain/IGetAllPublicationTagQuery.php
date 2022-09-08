<?php

namespace App\Slices\Publication\Domain;

class GetAllPublicationTagQueryOutputItem
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $name
    ) {
    }
}

interface IGetAllPublicationTagQuery
{
    public function execute(int $id): array;
}
