<?php

namespace App\Slices\PublicationReview\Domain;

use DateTime;

class GetAllPublicationReviewQueryOutputItem
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

interface IGetAllPublicationReviewQuery
{
    public function execute(int $publicationId): array;
}
