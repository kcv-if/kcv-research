<?php

namespace App\Slices\Publication\UseCase;

use App\Slices\Publication\Domain\IGetAllPublicationAuthorQuery;
use App\Slices\Publication\Domain\IGetByUuidPublicationQuery;
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

interface IGetByUuidPublicationUseCase
{
    public function execute(string $uuid): GetByUuidPublicationResponse;
}

class GetByUuidPublicationUseCase implements IGetByUuidPublicationUseCase
{
    public function __construct(
        private IGetByUuidPublicationQuery $getByUuidPublicationQuery,
        private IGetAllPublicationAuthorQuery $getAllPublicationAuthorQuery
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

        $authorRows = $this->getAllPublicationAuthorQuery->execute($row->id);
        $authors = [];
        foreach ($authorRows as $ar) {
            $authors[] = new GetByUuidPublicationResponseAuthorItem(
                $ar->uuid,
                $ar->name,
                $ar->email,
                $ar->telephone
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
            $row->createdAt,
            $row->updatedAt
        );
    }
}
