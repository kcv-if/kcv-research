<?php

namespace App\Slices\Dataset\UseCase;

use App\Slices\Dataset\Domain\IDeleteDatasetAuthorCommand;
use App\Slices\Dataset\Domain\IDeleteDatasetTagCommand;
use App\Slices\Dataset\Domain\IGetAllDatasetAuthorQuery;
use App\Slices\Dataset\Domain\IGetAllDatasetTagQuery;
use App\Slices\Dataset\Domain\IGetByUuidDatasetQuery;
use App\Slices\Dataset\Domain\IStoreDatasetAuthorCommand;
use App\Slices\Dataset\Domain\IStoreDatasetTagCommand;
use App\Slices\Dataset\Domain\IUpdateDatasetCommand;
use App\Slices\Dataset\Domain\StoreDatasetAuthorCommandInput;
use App\Slices\Dataset\Domain\StoreDatasetTagCommandInput;
use App\Slices\Dataset\Domain\UpdateDatasetCommandInput;
use App\Slices\Tag\Domain\IGetByUuidTagQuery;
use App\Slices\User\Domain\IGetByUuidUserQuery;
use Carbon\Carbon;
use Exception;

class UpdateDatasetRequest
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $description,
        public string $downloadLink,
        public string $status,
        public array $tags,
        public array $authors
    ) {
    }
}

interface IUpdateDatasetUseCase
{
    public function execute(UpdateDatasetRequest $request): void;
}

class UpdateDatasetUseCase implements IUpdateDatasetUseCase
{
    public function __construct(
        private IGetByUuidDatasetQuery $getByUuidDatasetQuery,
        private IGetByUuidUserQuery $getByUuidUserQuery,
        private IGetByUuidTagQuery $getByUuidTagQuery,
        private IUpdateDatasetCommand $updateDatasetCommand,
        private IGetAllDatasetAuthorQuery $getAllDatasetAuthorQuery,
        private IDeleteDatasetAuthorCommand $deleteDatasetAuthorCommand,
        private IStoreDatasetAuthorCommand $storeDatasetAuthorCommand,
        private IGetAllDatasetTagQuery $getAllDatasetTagQuery,
        private IDeleteDatasetTagCommand $deleteDatasetTagCommand,
        private IStoreDatasetTagCommand $storeDatasetTagCommand,
    ) {
    }

    public function execute(UpdateDatasetRequest $request): void
    {
        $datasetRow = null;

        try {
            $datasetRow = $this->getByUuidDatasetQuery->execute($request->uuid);
        } catch (Exception $e) {
            throw new Exception("unable to get Dataset by uuid");
        }

        if (!$datasetRow->success) {
            throw new Exception("Dataset not found");
        }

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

        try {
            $this->updateDatasetCommand->execute(new UpdateDatasetCommandInput(
                $datasetRow->id,
                $request->name,
                $request->description,
                $request->downloadLink,
                $request->status,
                Carbon::now()
            ));
        } catch (Exception $e) {
            throw new Exception("unable to update Dataset");
        }

        // delete old authors
        $oldAuthorRows = [];
        try {
            $oldAuthorRows = $this->getAllDatasetAuthorQuery->execute($datasetRow->id);
        } catch (Exception $e) {
            throw new Exception("unable to get all Dataset authors");
        }
        foreach ($oldAuthorRows as $ar) {
            try {
                $this->deleteDatasetAuthorCommand->execute($datasetRow->id, $ar->id);
            } catch (Exception $e) {
                throw new Exception("unable to delete Dataset author");
            }
        }

        // add authors
        foreach ($authorRows as $ar) {
            try {
                $this->storeDatasetAuthorCommand->execute(new StoreDatasetAuthorCommandInput(
                    $ar->id,
                    $datasetRow->id
                ));
            } catch (Exception $e) {
                throw new Exception("unable to store Dataset author");
            }
        }

        // delete old tags
        $oldTagRows = [];
        try {
            $oldTagRows = $this->getAllDatasetTagQuery->execute($datasetRow->id);
        } catch (Exception $e) {
            throw new Exception("unable to get all Dataset tags");
        }
        foreach ($oldTagRows as $tr) {
            try {
                $this->deleteDatasetTagCommand->execute($datasetRow->id, $tr->id);
            } catch (Exception $e) {
                throw new Exception("unable to delete Dataset tag");
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
                throw new Exception("unable to store Dataset tag");
            }
        }
    }
}
