<?php

namespace App\Slices\User\Domain;

use DateTime;

class StoreUserCommandInput
{
    public function __construct(
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

interface IStoreUserCommand
{
    public function execute(StoreUserCommandInput $input): void;
}
