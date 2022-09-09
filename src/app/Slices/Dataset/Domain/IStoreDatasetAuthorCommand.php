<?php

namespace App\Slices\Dataset\Domain;

class StoreDatasetAuthorCommandInput
{
    public function __construct(
        public int $user_id,
        public int $dataset_id,
    ) {
    }
}

interface IStoreDatasetAuthorCommand
{
    public function execute(StoreDatasetAuthorCommandInput $input): void;
}
