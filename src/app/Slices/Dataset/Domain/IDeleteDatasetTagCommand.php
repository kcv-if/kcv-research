<?php

namespace App\Slices\Dataset\Domain;

interface IDeleteDatasetTagCommand
{
    public function execute(int $datasetId, int $tagId): void;
}
