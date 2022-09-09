<?php

namespace App\Slices\Dataset\Repository\MySql;

use App\Slices\Dataset\Domain\IDeleteDatasetCommand;
use Illuminate\Support\Facades\DB;

class MySqlDeleteDatasetCommand implements IDeleteDatasetCommand
{
    public function execute(int $id): void
    {
        DB::delete("DELETE FROM datasets WHERE id = ?", [$id]);
    }
}
