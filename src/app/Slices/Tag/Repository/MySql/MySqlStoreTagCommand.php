<?php

namespace App\Slices\Tag\Repository\MySql;

use App\Slices\Tag\Domain\IStoreTagCommand;
use App\Slices\Tag\Domain\StoreTagCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlStoreTagCommand implements IStoreTagCommand
{
    public function execute(StoreTagCommandInput $input): void
    {
        DB::insert("INSERT INTO tags (uuid, name) VALUES (?, ?)", [$input->uuid, $input->name]);
    }
}
