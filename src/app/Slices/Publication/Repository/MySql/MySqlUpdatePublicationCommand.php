<?php

namespace App\Slices\Publication\Repository\MySql;

use App\Slices\Publication\Domain\IUpdatePublicationCommand;
use App\Slices\Publication\Domain\UpdatePublicationCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlUpdatePublicationCommand implements IUpdatePublicationCommand
{
    public function execute(UpdatePublicationCommandInput $input): void
    {
        DB::update(
            "UPDATE publications
            SET
                name = ?,
                excerpt = ?,
                abstract = ?,
                download_link = ?,
                status = ?,
                updated_at = ?
            WHERE id = ?
            ",
            [
                $input->name,
                $input->excerpt,
                $input->abstract,
                $input->downloadLink,
                $input->status,
                $input->updatedAt,
                $input->id
            ]
        );
    }
}
