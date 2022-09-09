<?php

namespace App\Slices\Dataset\Domain;

class StoreDatasetTagCommandInput
{
    public function __construct(
        public int $dataset_id,
        public int $tag_id,
    ) {
    }
}

interface IStoreDatasetTagCommand
{
    public function execute(StoreDatasetTagCommandInput $input): void;
}
