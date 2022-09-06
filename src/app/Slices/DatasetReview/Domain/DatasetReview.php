<?php

namespace App\Slices\DatasetReview\Domain;

use App\Slices\Dataset\Domain\Dataset;
use App\Slices\User\Domain\User;
use DateTime;

class DatasetReview
{
    public function __construct(
        private User $user,
        private Dataset $dataset,
        private string $comment,
        private DateTime $createdAt
    ) {
    }
}
