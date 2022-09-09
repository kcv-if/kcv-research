<?php

namespace App\Slices\PublicationReview\Domain;

use App\Slices\Publication\Domain\Publication;
use App\Slices\User\Domain\User;
use DateTime;

class PublicationReview
{
    public function __construct(
        private User $user,
        private Publication $publication,
        private string $comment,
        private DateTime $createdAt
    ) {
    }
}
