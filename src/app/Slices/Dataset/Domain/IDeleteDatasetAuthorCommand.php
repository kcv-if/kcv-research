<?php

namespace App\Slices\Dataset\Domain;

interface IDeleteDatasetAuthorCommand
{
    public function execute(int $datasetId, int $authorId): void;
}
