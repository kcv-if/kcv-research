<?php

namespace App\Slices\Publication\Repository\MySql;

use App\Slices\Publication\Domain\IDeletePublicationAuthorCommand;
use Illuminate\Support\Facades\DB;

class MySqlDeletePublicationAuthorCommand implements IDeletePublicationAuthorCommand
{
    public function execute(int $publicationId, int $authorId): void
    {
        DB::delete(
            "DELETE FROM publication_authors
            WHERE user_id = ? AND publication_id = ?
            ",
            [
                $authorId,
                $publicationId
            ]
        );
    }
}
