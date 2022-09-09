<?php

namespace App\Slices\User\Repository\MySql;

use App\Slices\User\Domain\GetAllUserQueryOutputItem;
use App\Slices\User\Domain\IGetAllUserQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MySqlGetAllUserQuery implements IGetAllUserQuery
{
    public function execute(): array
    {
        $rows = DB::select(
            "SELECT
                id,
                uuid,
                role,
                name,
                email,
                password,
                telephone,
                created_at
            FROM users",
            []
        );
        $output = [];
        foreach ($rows as $row) {
            $output[] = new GetAllUserQueryOutputItem(
                $row->id,
                $row->uuid,
                $row->role,
                $row->name,
                $row->email,
                $row->password,
                $row->telephone,
                Carbon::parse($row->created_at),
            );
        }
        return $output;
    }
}
