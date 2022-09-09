<?php

namespace App\Slices\Dataset\UseCase;

use App\Slices\Dataset\Domain\IGetByUuidDatasetQuery;
use App\Slices\Dataset\Domain\IStoreDatasetAuthorCommand;
use App\Slices\Dataset\Domain\IStoreDatasetCommand;
use App\Slices\Dataset\Domain\IStoreDatasetTagCommand;
use App\Slices\Dataset\Domain\Dataset;
use App\Slices\Dataset\Domain\StoreDatasetAuthorCommandInput;
use App\Slices\Dataset\Domain\StoreDatasetCommandInput;
use App\Slices\Dataset\Domain\StoreDatasetTagCommandInput;
use App\Slices\Tag\Domain\IGetByUuidTagQuery;
use App\Slices\User\Domain\IGetByUuidUserQuery;
use Carbon\Carbon;
use Exception;
use Ramsey\Uuid\Uuid;

class StoreDatasetRequest
{
    public function __construct(
        public string $name,
        public string $description,
        public string $downloadLink,
        public string $status,
        public array $tags,
        public array $authors
    ) {
    }
}

interface IStoreDatasetUseCase
{
    public function execute(StoreDatasetRequest $request): void;
}

class StoreDatasetUseCase implements IStoreDatasetUseCase
{
    public function __construct(
        private IStoreDatasetCommand $storeDatasetCommand,
        private IGetByUuidUserQuery $getByUuidUserQuery,
        private IGetByUuidTagQuery $getByUuidTagQuery,
        private IGetByUuidDatasetQuery $getByUuidDatasetQuery,
        private IStoreDatasetAuthorCommand $storeDatasetAuthorCommand,
        private IStoreDatasetTagCommand $storeDatasetTagCommand
    ) {
    }

    public function execute(StoreDatasetRequest $request): void
    {
        // check authors exist
        $authorRows = [];
        foreach ($request->authors as $author_uuid) {
            $authorRow = null;

            try {
                $authorRow = $this->getByUuidUserQuery->execute($author_uuid);
                $authorRows[] = $authorRow;
            } catch (Exception $e) {
                throw new Exception("unable to get user by uuid");
            }

            if (!$authorRow->success) {
                throw new Exception("user not found");
            }
        }

        // check tags exist
        $tagRows = [];
        foreach ($request->tags as $tag_uuid) {
            $tagRow = null;

            try {
                $tagRow = $this->getByUuidTagQuery->execute($tag_uuid);
                $tagRows[] = $tagRow;
            } catch (Exception $e) {
                throw new Exception("unable to get tag by uuid");
            }

            if (!$tagRow->success) {
                throw new Exception("tag not found");
            }
        }

        $uuid = Uuid::uuid4();
        try {
            $dataset = new Dataset(
                0,
                $uuid,
                $request->name,
                $request->description,
                $request->downloadLink,
                $request->status,
                [],
                [],
                [],
                [],
                Carbon::now(),
                null
            );
            $this->storeDatasetCommand->execute(new StoreDatasetCommandInput(
                $dataset->getUuid(),
                $dataset->getName(),
                $dataset->getDescription(),
                $dataset->getDownloadLink(),
                $dataset->getStatus(),
                $dataset->getCreatedAt()
            ));
        } catch (Exception $e) {
            throw $e;
            // throw new Exception('unable to store dataset');
        }

        $datasetRow = null;

        try {
            $datasetRow = $this->getByUuidDatasetQuery->execute($uuid);
        } catch (Exception $e) {
            throw new Exception("unable to get dataset by uuid");
        }

        if (!$datasetRow->success) {
            throw new Exception("Dataset not found");
        }

        // add authors
        foreach ($authorRows as $ar) {
            try {
                $this->storeDatasetAuthorCommand->execute(new StoreDatasetAuthorCommandInput(
                    $ar->id,
                    $datasetRow->id
                ));
            } catch (Exception $e) {
                throw new Exception("unable to store dataset author");
            }
        }

        // add tags
        foreach ($tagRows as $tr) {
            try {
                $this->storeDatasetTagCommand->execute(new StoreDatasetTagCommandInput(
                    $datasetRow->id,
                    $tr->id
                ));
            } catch (Exception $e) {
                throw new Exception("unable to store dataset tag");
            }
        }
    }
}
