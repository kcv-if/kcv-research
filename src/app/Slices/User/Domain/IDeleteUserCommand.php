<?php

namespace App\Slices\User\Domain;

interface IDeleteUserCommand
{
    public function execute(int $id): void;
}
