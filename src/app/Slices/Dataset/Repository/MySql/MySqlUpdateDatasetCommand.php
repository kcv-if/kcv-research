<?php

namespace App\Slices\Dataset\Repository\MySql;

use App\Slices\Dataset\Domain\IUpdateDatasetCommand;
use App\Slices\Dataset\Domain\UpdateDatasetCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlUpdateDatasetCommand implements IUpdateDatasetCommand
{
    public function execute(UpdateDatasetCommandInput $input): void
    {
        DB::update(
            "UPDATE datasets
            SET
                name = ?,
                description = ?,
                download_link = ?,
                status = ?,
                updated_at = ?
            WHERE id = ?
            ",
            [
                $input->name,
                $input->description,
                $input->downloadLink,
                $input->status,
                $input->updatedAt,
                $input->id
            ]
        );
    }
}
