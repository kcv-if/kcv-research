<?php

namespace App\Slices\Dataset\Repository\MySql;

use App\Slices\Dataset\Domain\IDeleteDatasetAuthorCommand;
use Illuminate\Support\Facades\DB;

class MySqlDeleteDatasetAuthorCommand implements IDeleteDatasetAuthorCommand
{
    public function execute(int $datasetId, int $authorId): void
    {
        DB::delete(
            "DELETE FROM dataset_authors
            WHERE user_id = ? AND dataset_id = ?
            ",
            [
                $authorId,
                $datasetId
            ]
        );
    }
}
