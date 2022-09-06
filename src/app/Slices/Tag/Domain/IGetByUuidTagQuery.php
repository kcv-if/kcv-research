<?php

namespace App\Slices\Tag\Domain;

class GetByUuidTagQueryOutput
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $name,
    ) {
    }
}

interface IGetByUuidTagQuery
{
    public function execute(): array;
}
