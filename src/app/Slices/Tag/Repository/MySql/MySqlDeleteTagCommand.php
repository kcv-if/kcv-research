<?php

namespace App\Slices\Tag\Repository\MySql;

use App\Slices\Tag\Domain\IDeleteTagCommand;
use Illuminate\Support\Facades\DB;

class MySqlDeleteTagCommand implements IDeleteTagCommand
{
    public function execute(int $id): void
    {
        DB::delete("DELETE FROM tags WHERE id = ?", [$id]);
    }
}
