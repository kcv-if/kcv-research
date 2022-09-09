<?php

namespace App\Slices\Dataset\Repository\MySql;

use App\Slices\Dataset\Domain\GetByUuidDatasetQueryOutput;
use App\Slices\Dataset\Domain\IGetByUuidDatasetQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MySqlGetByUuidDatasetQuery implements IGetByUuidDatasetQuery
{
    public function execute(string $uuid): GetByUuidDatasetQueryOutput
    {
        $row = DB::table('datasets')->where('uuid', $uuid)->first();

        if (!$row) {
            return new GetByUuidDatasetQueryOutput(
                false,
                0,
                "",
                "",
                "",
                "",
                "",
                null,
                null
            );
        }

        return new GetByUuidDatasetQueryOutput(
            true,
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
}
