<?php

namespace App\Slices\Publication\Repository\MySql;

use App\Slices\Publication\Domain\IDeletePublicationTagCommand;
use Illuminate\Support\Facades\DB;

class MySqlDeletePublicationTagCommand implements IDeletePublicationTagCommand
{
    public function execute(int $publicationId, int $tagId): void
    {
        DB::delete(
            "DELETE FROM publication_tags
            WHERE publication_id = ? AND tag_id = ?
            ",
            [
                $publicationId,
                $tagId
            ]
        );
    }
}
