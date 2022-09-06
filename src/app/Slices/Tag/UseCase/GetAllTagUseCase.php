<?php

namespace App\Slices\Tag\UseCase;

use App\Slices\Tag\Domain\IGetAllTagQuery;
use Exception;

class GetAllTagResponseItem
{
    public function __construct(
        public string $uuid,
        public string $name
    ) {
    }
}

interface IGetAllTagUseCase
{
    public function execute(): array;
}

class GetAllTagUseCase implements IGetAllTagUseCase
{
    public function __construct(
        private IGetAllTagQuery $getAllTagQuery
    ) {
    }

    public function execute(): array
    {
        try {
            $rows = $this->getAllTagQuery->execute();
            $response = [];
            foreach ($rows as $row) {
                $response[] = new GetAllTagResponseItem(
                    $row->uuid,
                    $row->name
                );
            }
            return $response;
        } catch (Exception $e) {
            throw new Exception("unable to get all tags");
        }
    }
}
