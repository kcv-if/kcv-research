<?php

namespace App\Slices\PublicationReview\Repository\MySql;

use App\Slices\PublicationReview\Domain\GetAllPublicationReviewQueryOutputItem;
use App\Slices\PublicationReview\Domain\IGetAllPublicationReviewQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MySqlGetAllPublicationReviewQuery implements IGetAllPublicationReviewQuery
{
    public function execute(int $publicationId): array
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
                FROM publication_reviews
                WHERE publication_id = ?
            ) pr
            JOIN users u
            ON pr.user_id = u.id;
            ",
            [$publicationId]
        );
        $output = [];
        foreach ($rows as $row) {
            $output[] = new GetAllPublicationReviewQueryOutputItem(
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
