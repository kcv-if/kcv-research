<?php

namespace App\Slices\Tag\UseCase;

use App\Slices\Tag\Domain\IGetByUuidTagQuery;
use App\Slices\Tag\Domain\IUpdateTagCommand;
use App\Slices\Tag\Domain\UpdateTagCommandInput;
use Carbon\Carbon;
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
        $row = null;

        try {
            $row = $this->getByUuidTagQuery->execute($request->uuid);
        } catch (Exception $e) {
            throw new Exception("unable to get tag by uuid");
        }

        if (!$row->success) {
            throw new Exception("tag not found");
        }

        try {
            $this->updateTagCommand->execute(new UpdateTagCommandInput(
                $row->id,
                $request->name,
                Carbon::now()
            ));
        } catch (Exception $e) {
            throw new Exception("unable to update tag");
        }
    }
}
