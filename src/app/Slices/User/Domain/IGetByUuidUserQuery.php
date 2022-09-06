<?php

namespace App\Slices\User\Domain;

use DateTime;

class GetByUuidUserQueryOutput
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $role,
        public string $name,
        public string $email,
        public string $password,
        public string $telephone,
        public DateTime $createdAt
    ) {
    }
}

interface IGetByUuidUserQuery
{
    public function execute(string $uuid): GetByUuidUserQueryOutput;
}
