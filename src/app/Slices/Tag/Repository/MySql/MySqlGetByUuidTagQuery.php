<?php

namespace App\Slices\Tag\Repository\MySql;

use App\Slices\Tag\Domain\GetByUuidTagQueryOutput;
use App\Slices\Tag\Domain\IGetByUuidTagQuery;
use Illuminate\Support\Facades\DB;

class MySqlGetByUuidTagQuery implements IGetByUuidTagQuery
{
    public function execute(string $uuid): GetByUuidTagQueryOutput
    {
        $row = DB::table('tags')->where('uuid', $uuid)->first();

        if (!$row) {
            return new GetByUuidTagQueryOutput(
                false,
                0,
                "",
                ""
            );
        }

        return new GetByUuidTagQueryOutput(
            true,
            $row->id,
            $row->uuid,
            $row->name
        );
    }
}
