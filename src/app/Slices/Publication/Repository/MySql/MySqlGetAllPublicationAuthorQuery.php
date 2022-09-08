<?php

namespace App\Slices\Publication\Repository\MySql;

use App\Slices\Publication\Domain\GetAllPublicationAuthorQueryOutputItem;
use App\Slices\Publication\Domain\IGetAllPublicationAuthorQuery;
use Illuminate\Support\Facades\DB;

class MySqlGetAllPublicationAuthorQuery implements IGetAllPublicationAuthorQuery
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
                FROM publication_authors
                WHERE publication_id = ?
            ) pa
            JOIN users u
            ON pa.user_id = u.id;
            ",
            [$id]
        );
        $output = [];
        foreach ($rows as $row) {
            $output[] = new GetAllPublicationAuthorQueryOutputItem(
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
