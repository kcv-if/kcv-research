<?php

namespace App\Slices\Publication\Domain;

interface IDeletePublicationCommand
{
    public function execute(int $id): void;
}
