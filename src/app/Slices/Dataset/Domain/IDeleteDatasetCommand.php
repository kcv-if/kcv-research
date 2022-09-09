<?php

namespace App\Slices\Dataset\Domain;

interface IDeleteDatasetCommand
{
    public function execute(int $id): void;
}
