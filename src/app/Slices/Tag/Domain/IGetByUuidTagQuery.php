<?php

namespace App\Slices\Tag\Domain;

class GetByUuidTagQueryOutput
{
    public function __construct(
        public bool $success,
        public int $id,
        public string $uuid,
        public string $name
    ) {
    }
}

interface IGetByUuidTagQuery
{
    public function execute(string $uuid): GetByUuidTagQueryOutput;
}
