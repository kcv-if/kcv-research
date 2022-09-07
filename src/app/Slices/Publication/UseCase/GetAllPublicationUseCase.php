<?php

namespace App\Slices\Publication\UseCase;

use App\Slices\Publication\Domain\IGetAllPublicationQuery;
use DateTime;
use Exception;

class GetAllPublicationResponseItem
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $excerpt,
        public string $abstract,
        public string $downloadLink,
        public string $status,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {
    }
}

interface IGetAllPublicationUseCase
{
    public function execute(): array;
}

class GetAllPublicationUseCase implements IGetAllPublicationUseCase
{
    public function __construct(
        private IGetAllPublicationQuery $getAllPublicationQuery
    ) {
    }

    public function execute(): array
    {
        try {
            $rows = $this->getAllPublicationQuery->execute();
            $response = [];
            foreach ($rows as $row) {
                $response[] = new GetAllPublicationResponseItem(
                    $row->uuid,
                    $row->name,
                    $row->excerpt,
                    $row->abstract,
                    $row->downloadLink,
                    $row->status,
                    $row->createdAt,
                    $row->updatedAt
                );
            }
            return $response;
        } catch (Exception $e) {
            throw new Exception("unable to get all publications");
        }
    }
}
