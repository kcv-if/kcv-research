<?php

namespace App\Slices\Dataset\Domain;

class GetAllDatasetTagQueryOutputItem
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $name
    ) {
    }
}

interface IGetAllDatasetTagQuery
{
    public function execute(int $id): array;
}
