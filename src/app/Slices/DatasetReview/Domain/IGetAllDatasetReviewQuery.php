<?php

namespace App\Slices\DatasetReview\Domain;

use DateTime;

class GetAllDatasetReviewQueryOutputItem
{
    public function __construct(
        public int $id,
        public string $uuid,
        public string $name,
        public string $email,
        public string $telephone,
        public string $comment,
        public DateTime $createdAt
    ) {
    }
}

interface IGetAllDatasetReviewQuery
{
    public function execute(int $datasetId): array;
}
