<?php

namespace App\Slices\DatasetReview\Repository\MySql;

use App\Slices\DatasetReview\Domain\GetAllDatasetReviewQueryOutputItem;
use App\Slices\DatasetReview\Domain\IGetAllDatasetReviewQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MySqlGetAllDatasetReviewQuery implements IGetAllDatasetReviewQuery
{
    public function execute(int $datasetId): array
    {
        $rows = DB::select(
            "
            SELECT
                u.id,
                u.uuid,
                u.name,
                u.email,
                u.telephone,
                pr.comment,
                pr.created_at
            FROM (
                SELECT *
                FROM dataset_reviews
                WHERE dataset_id = ?
            ) pr
            JOIN users u
            ON pr.user_id = u.id;
            ",
            [$datasetId]
        );
        $output = [];
        foreach ($rows as $row) {
            $output[] = new GetAllDatasetReviewQueryOutputItem(
                $row->id,
                $row->uuid,
                $row->name,
                $row->email,
                $row->telephone,
                $row->comment,
                Carbon::parse($row->created_at)
            );
        }
        return $output;
    }
}
