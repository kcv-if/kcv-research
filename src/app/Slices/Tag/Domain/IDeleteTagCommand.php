<?php

namespace App\Slices\Tag\Domain;

interface IDeleteTagCommand
{
    public function execute(int $id): bool;
}
