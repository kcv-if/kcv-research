<?php

namespace App\Slices\Tag\Repository\MySql;

use App\Slices\Tag\Domain\GetAllTagQueryOutputItem;
use App\Slices\Tag\Domain\IGetAllTagQuery;
use Illuminate\Support\Facades\DB;

class MySqlGetAllTagQuery implements IGetAllTagQuery
{
    public function execute(): array
    {
        $rows = DB::select("SELECT id, uuid, name FROM tags", []);
        $output = [];
        foreach ($rows as $row) {
            $output[] = new GetAllTagQueryOutputItem(
                $row->id,
                $row->uuid,
                $row->name
            );
        }
        return $output;
    }
}
