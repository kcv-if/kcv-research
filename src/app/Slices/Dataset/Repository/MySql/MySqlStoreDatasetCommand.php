<?php

namespace App\Slices\Dataset\Repository\MySql;

use App\Slices\Dataset\Domain\IStoreDatasetCommand;
use App\Slices\Dataset\Domain\StoreDatasetCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlStoreDatasetCommand implements IStoreDatasetCommand
{
    public function execute(StoreDatasetCommandInput $input): void
    {
        DB::insert(
            "INSERT INTO datasets (
                uuid,
                name,
                description,
                download_link,
                status,
                created_at
            )
            VALUES (?, ?, ?, ?, ?, ?)",
            [
                $input->uuid,
                $input->name,
                $input->description,
                $input->downloadLink,
                $input->status,
                $input->createdAt
            ]
        );
    }
}
