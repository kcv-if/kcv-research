<?php

namespace App\Slices\Publication\Repository\MySql;

use App\Slices\Publication\Domain\GetByUuidPublicationQueryOutput;
use App\Slices\Publication\Domain\IGetByUuidPublicationQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MySqlGetByUuidPublicationQuery implements IGetByUuidPublicationQuery
{
    public function execute(string $uuid): GetByUuidPublicationQueryOutput
    {
        $row = DB::table('publications')->where('uuid', $uuid)->first();

        if (!$row) {
            return new GetByUuidPublicationQueryOutput(
                false,
                0,
                "",
                "",
                "",
                "",
                "",
                "",
                null,
                null
            );
        }

        return new GetByUuidPublicationQueryOutput(
            true,
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
}
