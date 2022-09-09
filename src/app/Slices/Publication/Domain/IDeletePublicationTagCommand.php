<?php

namespace App\Slices\Publication\Domain;

interface IDeletePublicationTagCommand
{
    public function execute(int $publicationId, int $tagId): void;
}
