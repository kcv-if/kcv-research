<?php

namespace App\Slices\Dataset\Repository\MySql;

use App\Slices\Dataset\Domain\IDeleteDatasetTagCommand;
use Illuminate\Support\Facades\DB;

class MySqlDeleteDatasetTagCommand implements IDeleteDatasetTagCommand
{
    public function execute(int $datasetId, int $tagId): void
    {
        DB::delete(
            "DELETE FROM dataset_tags
            WHERE dataset_id = ? AND tag_id = ?
            ",
            [
                $datasetId,
                $tagId
            ]
        );
    }
}
