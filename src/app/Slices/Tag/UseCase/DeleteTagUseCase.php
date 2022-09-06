<?php

namespace App\Slices\Tag\UseCase;

use App\Slices\Tag\Domain\IDeleteTagCommand;
use App\Slices\Tag\Domain\IGetByUuidTagQuery;
use Exception;

interface IDeleteTagUseCase
{
    public function execute(string $uuid): void;
}

class DeleteTagUseCase implements IDeleteTagUseCase
{
    public function __construct(
        private IGetByUuidTagQuery $getByUuidTagQuery,
        private IDeleteTagCommand $deleteTagCommand
    ) {
    }

    public function execute(string $uuid): void
    {
        try {
            $row = $this->getByUuidTagQuery->execute($uuid);
            if (!$row) {
                throw new Exception("tag not found");
            }
            $this->deleteTagCommand->execute($row->id);
        } catch (Exception $e) {
            throw new Exception("unable to delete tag");
        }
    }
}
