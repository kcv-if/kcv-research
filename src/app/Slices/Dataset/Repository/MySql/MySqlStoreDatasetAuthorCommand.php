<?php

namespace App\Slices\Dataset\Repository\MySql;

use App\Slices\Dataset\Domain\IStoreDatasetAuthorCommand;
use App\Slices\Dataset\Domain\StoreDatasetAuthorCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlStoreDatasetAuthorCommand implements IStoreDatasetAuthorCommand
{
    public function execute(StoreDatasetAuthorCommandInput $input): void
    {
        DB::insert("INSERT INTO dataset_authors (user_id, dataset_id) VALUES (?, ?)", [
            $input->user_id,
            $input->dataset_id
        ]);
    }
}
