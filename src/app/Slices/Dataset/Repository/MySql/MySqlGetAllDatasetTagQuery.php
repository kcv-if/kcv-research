<?php

namespace App\Slices\Dataset\Repository\MySql;

use App\Slices\Dataset\Domain\GetAllDatasetTagQueryOutputItem;
use App\Slices\Dataset\Domain\IGetAllDatasetTagQuery;
use Illuminate\Support\Facades\DB;

class MySqlGetAllDatasetTagQuery implements IGetAllDatasetTagQuery
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
                FROM dataset_tags
                WHERE dataset_id = ?
            ) pt
            JOIN tags t
            ON pt.tag_id = t.id;
            ",
            [$id]
        );
        $output = [];
        foreach ($rows as $row) {
            $output[] = new GetAllDatasetTagQueryOutputItem(
                $row->id,
                $row->uuid,
                $row->name
            );
        }
        return $output;
    }
}
