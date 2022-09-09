<?php

namespace App\Slices\Dataset\Repository\MySql;

use App\Slices\Dataset\Domain\IStoreDatasetTagCommand;
use App\Slices\Dataset\Domain\StoreDatasetTagCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlStoreDatasetTagCommand implements IStoreDatasetTagCommand
{
    public function execute(StoreDatasetTagCommandInput $input): void
    {
        DB::insert("INSERT INTO dataset_tags (dataset_id, tag_id) VALUES (?, ?)", [
            $input->dataset_id,
            $input->tag_id
        ]);
    }
}
