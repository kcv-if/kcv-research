<?php

namespace App\Slices\Tag\UseCase;

use App\Slices\Tag\Domain\IStoreTagCommand;
use App\Slices\Tag\Domain\StoreTagCommandInput;
use App\Slices\Tag\Domain\Tag;
use Exception;
use Ramsey\Uuid\Uuid;

class StoreTagRequest
{
    public function __construct(
        public string $name,
    ) {
    }
}

interface IStoreTagUseCase
{
    public function execute(StoreTagRequest $request): void;
}

class StoreTagUseCase implements IStoreTagUseCase
{
    public function __construct(
        private IStoreTagCommand $storeTagCommand
    ) {
    }

    public function execute(StoreTagRequest $request): void
    {
        try {
            $tag = new Tag(0, Uuid::uuid4(), $request->name);
            $this->storeTagCommand->execute(new StoreTagCommandInput(
                $tag->getUuid(),
                $tag->getName()
            ));
        } catch (Exception $e) {
            throw new Exception("unable to store tag");
        }
    }
}
