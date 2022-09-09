<?php

namespace App\Slices\Publication\Repository\MySql;

use App\Slices\Publication\Domain\IStorePublicationAuthorCommand;
use App\Slices\Publication\Domain\StorePublicationAuthorCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlStorePublicationAuthorCommand implements IStorePublicationAuthorCommand
{
    public function execute(StorePublicationAuthorCommandInput $input): void
    {
        DB::insert("INSERT INTO publication_authors (user_id, publication_id) VALUES (?, ?)", [
            $input->user_id,
            $input->publication_id
        ]);
    }
}
