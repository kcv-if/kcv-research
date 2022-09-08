<?php

namespace App\Slices\Publication\Repository\MySql;

use App\Slices\Publication\Domain\GetAllPublicationTagQueryOutputItem;
use App\Slices\Publication\Domain\IGetAllPublicationTagQuery;
use Illuminate\Support\Facades\DB;

class MySqlGetAllPublicationTagQuery implements IGetAllPublicationTagQuery
{
    public function execute(int $id): array
    {
        $rows = DB::select(
            "
            SELECT
                t.id,
                t.uuid,
                t.name
            FROM (
                SELECT tag_id
                FROM publication_tags
                WHERE publication_id = ?
            ) pt
            JOIN tags t
            ON pt.tag_id = t.id;
            ",
            [$id]
        );
        $output = [];
        foreach ($rows as $row) {
            $output[] = new GetAllPublicationTagQueryOutputItem(
                $row->id,
                $row->uuid,
                $row->name
            );
        }
        return $output;
    }
}
