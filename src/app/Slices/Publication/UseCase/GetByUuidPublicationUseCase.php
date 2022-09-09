<?php

namespace App\Slices\Publication\UseCase;

use App\Slices\Publication\Domain\IGetAllPublicationAuthorQuery;
use App\Slices\Publication\Domain\IGetAllPublicationTagQuery;
use App\Slices\Publication\Domain\IGetByUuidPublicationQuery;
use App\Slices\PublicationReview\Domain\IGetAllPublicationReviewQuery;
use DateTime;
use Exception;

class GetByUuidPublicationResponse
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $excerpt,
        public string $abstract,
        public string $downloadLink,
        public string $status,
        public array $authors,
        public array $tags,
        public array $reviews,
        public DateTime $createdAt,
        public ?DateTime $updatedAt
    ) {
    }
}

class GetByUuidPublicationResponseAuthorItem
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $email,
        public string $telephone
    ) {
    }
}

class GetByUuidPublicationResponseReviewItem
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $email,
        public string $telephone,
        public string $comment,
        public DateTime $createdAt
    ) {
    }
}

class GetByUuidPublicationResponseTagItem
{
    public function __construct(
        public string $uuid,
        public string $name
    ) {
    }
}

interface IGetByUuidPublicationUseCase
{
    public function execute(string $uuid): GetByUuidPublicationResponse;
}

class GetByUuidPublicationUseCase implements IGetByUuidPublicationUseCase
{
    public function __construct(
        private IGetByUuidPublicationQuery $getByUuidPublicationQuery,
        private IGetAllPublicationAuthorQuery $getAllPublicationAuthorQuery,
        private IGetAllPublicationReviewQuery $getAllPublicationReviewQuery,
        private IGetAllPublicationTagQuery $getAllPublicationTagQuery
    ) {
    }

    public function execute(string $uuid): GetByUuidPublicationResponse
    {
        $row = null;

        try {
            $row = $this->getByUuidPublicationQuery->execute($uuid);
        } catch (Exception $e) {
            throw new Exception("unable to get publication by uuid");
        }

        if (!$row->success) {
            throw new Exception("publication not found");
        }

        $authorRows = [];
        try {
            $authorRows = $this->getAllPublicationAuthorQuery->execute($row->id);
        } catch (Exception $e) {
            throw new Exception("unable to get all publication authors");
        }
        $authors = [];
        foreach ($authorRows as $ar) {
            $authors[] = new GetByUuidPublicationResponseAuthorItem(
                $ar->uuid,
                $ar->name,
                $ar->email,
                $ar->telephone
            );
        }

        $reviewRows = [];
        try {
            $reviewRows = $this->getAllPublicationReviewQuery->execute($row->id);
        } catch (Exception $e) {
            throw new Exception("unable to get all publication reviews");
        }
        $reviews = [];
        foreach ($reviewRows as $rr) {
            $reviews[] = new GetByUuidPublicationResponseReviewItem(
                $rr->uuid,
                $rr->name,
                $rr->email,
                $rr->telephone,
                $rr->comment,
                $rr->createdAt
            );
        }

        $tagRows = [];
        try {
            $tagRows = $this->getAllPublicationTagQuery->execute($row->id);
        } catch (Exception $e) {
            throw new Exception("unable to get all publication tags");
        }
        $tags = [];
        foreach ($tagRows as $tr) {
            $tags[] = new GetByUuidPublicationResponseTagItem(
                $tr->uuid,
                $tr->name
            );
        }

        return new GetByUuidPublicationResponse(
            $row->uuid,
            $row->name,
            $row->excerpt,
            $row->abstract,
            $row->downloadLink,
            $row->status,
            $authors,
            $tags,
            $reviews,
            $row->createdAt,
            $row->updatedAt
        );
    }
}
