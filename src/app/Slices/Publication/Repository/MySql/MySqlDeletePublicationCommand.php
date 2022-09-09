<?php

namespace App\Slices\Publication\Repository\MySql;

use App\Slices\Publication\Domain\IDeletePublicationCommand;
use Illuminate\Support\Facades\DB;

class MySqlDeletePublicationCommand implements IDeletePublicationCommand
{
    public function execute(int $id): void
    {
        DB::delete("DELETE FROM publications WHERE id = ?", [$id]);
    }
}
