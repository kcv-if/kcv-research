<?php

namespace App\Slices\Tag\Repository\MySql;

use App\Slices\Tag\Domain\IUpdateTagCommand;
use App\Slices\Tag\Domain\UpdateTagCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlUpdateTagCommand implements IUpdateTagCommand
{
    public function execute(UpdateTagCommandInput $input): void
    {
        DB::update("UPDATE tags SET name = ? WHERE id = ?", [$input->name, $input->id]);
    }
}
