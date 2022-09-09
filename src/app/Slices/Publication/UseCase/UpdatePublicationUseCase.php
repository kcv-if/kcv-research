<?php

namespace App\Slices\Publication\UseCase;

use App\Slices\Publication\Domain\IDeletePublicationAuthorCommand;
use App\Slices\Publication\Domain\IDeletePublicationTagCommand;
use App\Slices\Publication\Domain\IGetAllPublicationAuthorQuery;
use App\Slices\Publication\Domain\IGetAllPublicationTagQuery;
use App\Slices\Publication\Domain\IGetByUuidPublicationQuery;
use App\Slices\Publication\Domain\IStorePublicationAuthorCommand;
use App\Slices\Publication\Domain\IStorePublicationTagCommand;
use App\Slices\Publication\Domain\IUpdatePublicationCommand;
use App\Slices\Publication\Domain\StorePublicationAuthorCommandInput;
use App\Slices\Publication\Domain\StorePublicationTagCommandInput;
use App\Slices\Publication\Domain\UpdatePublicationCommandInput;
use App\Slices\Tag\Domain\IGetByUuidTagQuery;
use App\Slices\User\Domain\IGetByUuidUserQuery;
use Carbon\Carbon;
use Exception;

class UpdatePublicationRequest
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $excerpt,
        public string $abstract,
        public string $downloadLink,
        public string $status,
        public array $tags,
        public array $authors
    ) {
    }
}

interface IUpdatePublicationUseCase
{
    public function execute(UpdatePublicationRequest $request): void;
}

class UpdatePublicationUseCase implements IUpdatePublicationUseCase
{
    public function __construct(
        private IGetByUuidPublicationQuery $getByUuidPublicationQuery,
        private IGetByUuidUserQuery $getByUuidUserQuery,
        private IGetByUuidTagQuery $getByUuidTagQuery,
        private IUpdatePublicationCommand $updatePublicationCommand,
        private IGetAllPublicationAuthorQuery $getAllPublicationAuthorQuery,
        private IDeletePublicationAuthorCommand $deletePublicationAuthorCommand,
        private IStorePublicationAuthorCommand $storePublicationAuthorCommand,
        private IGetAllPublicationTagQuery $getAllPublicationTagQuery,
        private IDeletePublicationTagCommand $deletePublicationTagCommand,
        private IStorePublicationTagCommand $storePublicationTagCommand,
    ) {
    }

    public function execute(UpdatePublicationRequest $request): void
    {
        $publicationRow = null;

        try {
            $publicationRow = $this->getByUuidPublicationQuery->execute($request->uuid);
        } catch (Exception $e) {
            throw new Exception("unable to get publication by uuid");
        }

        if (!$publicationRow->success) {
            throw new Exception("publication not found");
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
            $this->updatePublicationCommand->execute(new UpdatePublicationCommandInput(
                $publicationRow->id,
                $request->name,
                $request->excerpt,
                $request->abstract,
                $request->downloadLink,
                $request->status,
                Carbon::now()
            ));
        } catch (Exception $e) {
            throw new Exception("unable to update publication");
        }

        // delete old authors
        $oldAuthorRows = [];
        try {
            $oldAuthorRows = $this->getAllPublicationAuthorQuery->execute($publicationRow->id);
        } catch (Exception $e) {
            throw new Exception("unable to get all publication authors");
        }
        foreach ($oldAuthorRows as $ar) {
            try {
                $this->deletePublicationAuthorCommand->execute($publicationRow->id, $ar->id);
            } catch (Exception $e) {
                throw new Exception("unable to delete publication author");
            }
        }

        // add authors
        foreach ($authorRows as $ar) {
            try {
                $this->storePublicationAuthorCommand->execute(new StorePublicationAuthorCommandInput(
                    $ar->id,
                    $publicationRow->id
                ));
            } catch (Exception $e) {
                throw new Exception("unable to store publication author");
            }
        }

        // delete old tags
        $oldTagRows = [];
        try {
            $oldTagRows = $this->getAllPublicationTagQuery->execute($publicationRow->id);
        } catch (Exception $e) {
            throw new Exception("unable to get all publication tags");
        }
        foreach ($oldTagRows as $tr) {
            try {
                $this->deletePublicationTagCommand->execute($publicationRow->id, $tr->id);
            } catch (Exception $e) {
                throw new Exception("unable to delete publication tag");
            }
        }

        // add tags
        foreach ($tagRows as $tr) {
            try {
                $this->storePublicationTagCommand->execute(new StorePublicationTagCommandInput(
                    $publicationRow->id,
                    $tr->id
                ));
            } catch (Exception $e) {
                throw new Exception("unable to store publication tag");
            }
        }
    }
}
