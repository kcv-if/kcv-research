<?php

namespace App\Slices\Publication\Repository\MySql;

use App\Slices\Publication\Domain\IStorePublicationTagCommand;
use App\Slices\Publication\Domain\StorePublicationTagCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlStorePublicationTagCommand implements IStorePublicationTagCommand
{
    public function execute(StorePublicationTagCommandInput $input): void
    {
        DB::insert("INSERT INTO publication_tags (publication_id, tag_id) VALUES (?, ?)", [
            $input->publication_id,
            $input->tag_id
        ]);
    }
}
