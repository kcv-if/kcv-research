<?php

namespace App\Slices\Dataset\Repository\MySql;

use App\Slices\Dataset\Domain\GetAllDatasetAuthorQueryOutputItem;
use App\Slices\Dataset\Domain\IGetAllDatasetAuthorQuery;
use Illuminate\Support\Facades\DB;

class MySqlGetAllDatasetAuthorQuery implements IGetAllDatasetAuthorQuery
{
    public function execute(int $id): array
    {
        $rows = DB::select(
            "
            SELECT
                u.id,
                u.uuid,
                u.name,
                u.email,
                u.telephone
            FROM (
                SELECT user_id
                FROM dataset_authors
                WHERE dataset_id = ?
            ) pa
            JOIN users u
            ON pa.user_id = u.id;
            ",
            [$id]
        );
        $output = [];
        foreach ($rows as $row) {
            $output[] = new GetAllDatasetAuthorQueryOutputItem(
                $row->id,
                $row->uuid,
                $row->name,
                $row->email,
                $row->telephone
            );
        }
        return $output;
    }
}
