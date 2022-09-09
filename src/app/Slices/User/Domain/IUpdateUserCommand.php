<?php

namespace App\Slices\User\Domain;

use DateTime;

class UpdateUserCommandInput
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password,
        public string $telephone,
        public DateTime $updatedAt
    ) {
    }
}

interface IUpdateUserCommand
{
    public function execute(UpdateUserCommandInput $input): void;
}
