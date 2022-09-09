<?php

namespace App\Slices\Publication\Repository\MySql;

use App\Slices\Publication\Domain\IStorePublicationCommand;
use App\Slices\Publication\Domain\StorePublicationCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlStorePublicationCommand implements IStorePublicationCommand
{
    public function execute(StorePublicationCommandInput $input): void
    {
        DB::insert(
            "INSERT INTO publications (
                uuid,
                name,
                excerpt,
                abstract,
                download_link,
                status,
                created_at
            )
            VALUES (?, ?, ?, ?, ?, ?, ?)",
            [
                $input->uuid,
                $input->name,
                $input->excerpt,
                $input->abstract,
                $input->downloadLink,
                $input->status,
                $input->createdAt
            ]
        );
    }
}
