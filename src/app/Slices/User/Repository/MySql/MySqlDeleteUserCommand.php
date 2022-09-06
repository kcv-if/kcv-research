<?php

namespace App\Slices\User\Repository\MySql;

use App\Slices\User\Domain\IDeleteUserCommand;
use Illuminate\Support\Facades\DB;

class MySqlDeleteUserCommand implements IDeleteUserCommand
{
    public function execute(int $id): void
    {
        DB::delete("DELETE FROM users WHERE id = ?", [$id]);
    }
}
