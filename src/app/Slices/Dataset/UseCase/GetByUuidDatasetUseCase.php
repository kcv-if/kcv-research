<?php

namespace App\Slices\Dataset\UseCase;

use App\Slices\Dataset\Domain\IGetAllDatasetAuthorQuery;
use App\Slices\Dataset\Domain\IGetAllDatasetTagQuery;
use App\Slices\Dataset\Domain\IGetByUuidDatasetQuery;
use App\Slices\DatasetReview\Domain\IGetAllDatasetReviewQuery;
use DateTime;
use Exception;

class GetByUuidDatasetResponse
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $description,
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

class GetByUuidDatasetResponseAuthorItem
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $email,
        public string $telephone
    ) {
    }
}

class GetByUuidDatasetResponseReviewItem
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

class GetByUuidDatasetResponseTagItem
{
    public function __construct(
        public string $uuid,
        public string $name
    ) {
    }
}

interface IGetByUuidDatasetUseCase
{
    public function execute(string $uuid): GetByUuidDatasetResponse;
}

class GetByUuidDatasetUseCase implements IGetByUuidDatasetUseCase
{
    public function __construct(
        private IGetByUuidDatasetQuery $getByUuidDatasetQuery,
        private IGetAllDatasetAuthorQuery $getAllDatasetAuthorQuery,
        private IGetAllDatasetReviewQuery $getAllDatasetReviewQuery,
        private IGetAllDatasetTagQuery $getAllDatasetTagQuery
    ) {
    }

    public function execute(string $uuid): GetByUuidDatasetResponse
    {
        $row = null;

        try {
            $row = $this->getByUuidDatasetQuery->execute($uuid);
        } catch (Exception $e) {
            throw new Exception("unable to get Dataset by uuid");
        }

        if (!$row->success) {
            throw new Exception("Dataset not found");
        }

        $authorRows = [];
        try {
            $authorRows = $this->getAllDatasetAuthorQuery->execute($row->id);
        } catch (Exception $e) {
            throw new Exception("unable to get all Dataset authors");
        }
        $authors = [];
        foreach ($authorRows as $ar) {
            $authors[] = new GetByUuidDatasetResponseAuthorItem(
                $ar->uuid,
                $ar->name,
                $ar->email,
                $ar->telephone
            );
        }

        $reviewRows = [];
        try {
            $reviewRows = $this->getAllDatasetReviewQuery->execute($row->id);
        } catch (Exception $e) {
            throw new Exception("unable to get all Dataset reviews");
        }
        $reviews = [];
        foreach ($reviewRows as $rr) {
            $reviews[] = new GetByUuidDatasetResponseReviewItem(
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
            $tagRows = $this->getAllDatasetTagQuery->execute($row->id);
        } catch (Exception $e) {
            throw new Exception("unable to get all Dataset tags");
        }
        $tags = [];
        foreach ($tagRows as $tr) {
            $tags[] = new GetByUuidDatasetResponseTagItem(
                $tr->uuid,
                $tr->name
            );
        }

        return new GetByUuidDatasetResponse(
            $row->uuid,
            $row->name,
            $row->description,
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
