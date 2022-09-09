<?php

namespace App\Slices\Publication\UseCase;

use App\Slices\Publication\Domain\IDeletePublicationCommand;
use App\Slices\Publication\Domain\IGetByUuidPublicationQuery;
use Exception;

interface IDeletePublicationUseCase
{
    public function execute(string $uuid): void;
}

class DeletePublicationUseCase implements IDeletePublicationUseCase
{
    public function __construct(
        private IGetByUuidPublicationQuery $getByUuidPublicationQuery,
        private IDeletePublicationCommand $deletePublicationCommand
    ) {
    }

    public function execute(string $uuid): void
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

        try {
            $this->deletePublicationCommand->execute($row->id);
        } catch (Exception $e) {
            throw new Exception("unable to delete publication");
        }
    }
}
