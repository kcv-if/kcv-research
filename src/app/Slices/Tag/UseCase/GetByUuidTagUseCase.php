<?php

namespace App\Slices\Tag\UseCase;

use App\Slices\Tag\Domain\IGetByUuidTagQuery;
use Exception;

class GetByUuidTagResponse
{
    public function __construct(
        public string $uuid,
        public string $name
    ) {
    }
}

interface IGetByUuidTagUseCase
{
    public function execute(string $uuid): GetByUuidTagResponse;
}

class GetByUuidTagUseCase implements IGetByUuidTagUseCase
{
    public function __construct(
        private IGetByUuidTagQuery $getByUuidTagQuery
    ) {
    }

    public function execute(string $uuid): GetByUuidTagResponse
    {
        $row = null;

        try {
            $row = $this->getByUuidTagQuery->execute($uuid);
        } catch (Exception $e) {
            throw new Exception("unable to get tag by uuid");
        }

        if (!$row->success) {
            throw new Exception("tag not found");
        }

        return new GetByUuidTagResponse(
            $row->uuid,
            $row->name
        );
    }
}
