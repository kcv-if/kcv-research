<?php

namespace App\Slices\Tag\Domain;

class GetAllTagQueryOutputItem
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $name,
    ) {
    }
}

interface IGetAllTagQuery
{
    public function execute(): array;
}
