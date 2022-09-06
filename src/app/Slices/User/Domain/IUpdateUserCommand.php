<?php

namespace App\Slices\User\Domain;

class UpdateUserCommandInput
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password,
        public string $telephone
    ) {
    }
}

interface IUpdateUserCommand
{
    public function execute(UpdateUserCommandInput $input): void;
}
