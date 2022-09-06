<?php

namespace App\Slices\User\Repository\MySql;

use App\Slices\User\Domain\GetByUuidUserQueryOutput;
use App\Slices\User\Domain\IGetByUuidUserQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MySqlGetByUuidUserQuery implements IGetByUuidUserQuery
{
    public function execute(string $uuid): GetByUuidUserQueryOutput
    {
        $row = DB::table('users')->where('uuid', $uuid)->first();
        return new GetByUuidUserQueryOutput(
            $row->id,
            $row->uuid,
            $row->role,
            $row->name,
            $row->email,
            $row->password,
            $row->telephone,
            Carbon::parse($row->created_at)
        );
    }
}
