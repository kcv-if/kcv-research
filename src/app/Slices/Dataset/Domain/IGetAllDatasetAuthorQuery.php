<?php

namespace App\Slices\Dataset\Domain;

class GetAllDatasetAuthorQueryOutputItem
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $name,
        public string $email,
        public string $telephone
    ) {
    }
}

interface IGetAllDatasetAuthorQuery
{
    public function execute(int $id): array;
}
