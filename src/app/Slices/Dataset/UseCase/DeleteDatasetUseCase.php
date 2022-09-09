<?php

namespace App\Slices\Dataset\UseCase;

use App\Slices\Dataset\Domain\IDeleteDatasetCommand;
use App\Slices\Dataset\Domain\IGetByUuidDatasetQuery;
use Exception;

interface IDeleteDatasetUseCase
{
    public function execute(string $uuid): void;
}

class DeleteDatasetUseCase implements IDeleteDatasetUseCase
{
    public function __construct(
        private IGetByUuidDatasetQuery $getByUuidDatasetQuery,
        private IDeleteDatasetCommand $deleteDatasetCommand
    ) {
    }

    public function execute(string $uuid): void
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

        try {
            $this->deleteDatasetCommand->execute($row->id);
        } catch (Exception $e) {
            throw new Exception("unable to delete Dataset");
        }
    }
}
