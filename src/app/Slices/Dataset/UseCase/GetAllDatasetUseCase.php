<?php

namespace App\Slices\Dataset\UseCase;

use App\Slices\Dataset\Domain\IGetAllDatasetQuery;
use DateTime;
use Exception;

class GetAllDatasetResponseItem
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $description,
        public string $downloadLink,
        public string $status,
        public DateTime $createdAt,
        public DateTime $updatedAt
    ) {
    }
}

interface IGetAllDatasetUseCase
{
    public function execute(): array;
}

class GetAllDatasetUseCase implements IGetAllDatasetUseCase
{
    public function __construct(
        private IGetAllDatasetQuery $getAllDatasetQuery
    ) {
    }

    public function execute(): array
    {
        try {
            $rows = $this->getAllDatasetQuery->execute();
            $response = [];
            foreach ($rows as $row) {
                $response[] = new GetAllDatasetResponseItem(
                    $row->uuid,
                    $row->name,
                    $row->description,
                    $row->downloadLink,
                    $row->status,
                    $row->createdAt,
                    $row->updatedAt
                );
            }
            return $response;
        } catch (Exception $e) {
            throw new Exception("unable to get all datasets");
        }
    }
}
