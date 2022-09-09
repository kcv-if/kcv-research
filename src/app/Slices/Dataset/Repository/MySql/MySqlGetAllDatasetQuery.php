<?php

namespace App\Slices\Dataset\Repository\MySql;

use App\Slices\Dataset\Domain\GetAllDatasetQueryOutputItem;
use App\Slices\Dataset\Domain\IGetAllDatasetQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MySqlGetAllDatasetQuery implements IGetAllDatasetQuery
{
    public function execute(): array
    {
        $rows = DB::select(
            "SELECT
                id,
                uuid,
                name,
                description,
                download_link,
                status,
                created_at,
                updated_at
            FROM datasets",
            []
        );
        $output = [];
        foreach ($rows as $row) {
            $output[] = new GetAllDatasetQueryOutputItem(
                $row->id,
                $row->uuid,
                $row->name,
                $row->description,
                $row->download_link,
                $row->status,
                Carbon::parse($row->created_at),
                Carbon::parse($row->updated_at)
            );
        }
        return $output;
    }
}
