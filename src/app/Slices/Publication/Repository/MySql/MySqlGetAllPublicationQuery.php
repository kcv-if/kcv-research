<?php

namespace App\Slices\Publication\Repository\MySql;

use App\Slices\Publication\Domain\GetAllPublicationQueryOutputItem;
use App\Slices\Publication\Domain\IGetAllPublicationQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MySqlGetAllPublicationQuery implements IGetAllPublicationQuery
{
    public function execute(): array
    {
        $rows = DB::select(
            "SELECT
                id,
                uuid,
                name,
                excerpt,
                abstract,
                download_link,
                status,
                created_at,
                updated_at
            FROM publications",
            []
        );
        $output = [];
        foreach ($rows as $row) {
            $output[] = new GetAllPublicationQueryOutputItem(
                $row->id,
                $row->uuid,
                $row->name,
                $row->excerpt,
                $row->abstract,
                $row->download_link,
                $row->status,
                Carbon::parse($row->created_at),
                Carbon::parse($row->updated_at)
            );
        }
        return $output;
    }
}
