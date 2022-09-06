<?php

namespace App\Slices\Tag\UseCase;

use App\Slices\Tag\Domain\IGetByUuidTagQuery;
use App\Slices\Tag\Domain\IUpdateTagCommand;
use App\Slices\Tag\Domain\UpdateTagCommandInput;
use Exception;

class UpdateTagRequest
{
    public function __construct(
        public string $uuid,
        public string $name,
    ) {
    }
}

interface IUpdateTagUseCase
{
    public function execute(UpdateTagRequest $request): void;
}

class UpdateTagUseCase implements IUpdateTagUseCase
{
    public function __construct(
        private IGetByUuidTagQuery $getByUuidTagQuery,
        private IUpdateTagCommand $updateTagCommand
    ) {
    }

    public function execute(UpdateTagRequest $request): void
    {
        try {
            $row = $this->getByUuidTagQuery->execute($request->uuid);
            if (!$row) {
                throw new Exception("tag not found");
            }
            $this->updateTagCommand->execute(new UpdateTagCommandInput(
                $row->id,
                $request->name
            ));
        } catch (Exception $e) {
            throw new Exception("unable to update tag");
        }
    }
}
