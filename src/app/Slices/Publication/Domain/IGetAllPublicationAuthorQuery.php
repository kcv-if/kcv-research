<?php

namespace App\Slices\Publication\Domain;

class GetAllPublicationAuthorQueryOutputItem
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

interface IGetAllPublicationAuthorQuery
{
    public function execute(int $id): array;
}
