<?php

namespace App\Slices\Publication\Domain;

interface IDeletePublicationAuthorCommand
{
    public function execute(int $publicationId, int $authorId): void;
}
