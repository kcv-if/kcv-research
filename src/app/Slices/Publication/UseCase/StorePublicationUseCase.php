<?php

namespace App\Slices\Publication\UseCase;

use App\Slices\Publication\Domain\IGetByUuidPublicationQuery;
use App\Slices\Publication\Domain\IStorePublicationAuthorCommand;
use App\Slices\Publication\Domain\IStorePublicationCommand;
use App\Slices\Publication\Domain\IStorePublicationTagCommand;
use App\Slices\Publication\Domain\Publication;
use App\Slices\Publication\Domain\StorePublicationAuthorCommandInput;
use App\Slices\Publication\Domain\StorePublicationCommandInput;
use App\Slices\Publication\Domain\StorePublicationTagCommandInput;
use App\Slices\Tag\Domain\IGetByUuidTagQuery;
use App\Slices\User\Domain\IGetByUuidUserQuery;
use Carbon\Carbon;
use Exception;
use Ramsey\Uuid\Uuid;

class StorePublicationRequest
{
    public function __construct(
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

interface IStorePublicationUseCase
{
    public function execute(StorePublicationRequest $request): void;
}

class StorePublicationUseCase implements IStorePublicationUseCase
{
    public function __construct(
        private IStorePublicationCommand $storePublicationCommand,
        private IGetByUuidUserQuery $getByUuidUserQuery,
        private IGetByUuidTagQuery $getByUuidTagQuery,
        private IGetByUuidPublicationQuery $getByUuidPublicationQuery,
        private IStorePublicationAuthorCommand $storePublicationAuthorCommand,
        private IStorePublicationTagCommand $storePublicationTagCommand
    ) {
    }

    public function execute(StorePublicationRequest $request): void
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
            $publication = new Publication(
                0,
                $uuid,
                $request->name,
                $request->excerpt,
                $request->abstract,
                $request->downloadLink,
                $request->status,
                [],
                [],
                [],
                [],
                Carbon::now(),
                null
            );
            $this->storePublicationCommand->execute(new StorePublicationCommandInput(
                $publication->getUuid(),
                $publication->getName(),
                $publication->getExcerpt(),
                $publication->getAbstract(),
                $publication->getDownloadLink(),
                $publication->getStatus(),
                $publication->getCreatedAt()
            ));
        } catch (Exception $e) {
            throw new Exception('unable to store publication');
        }

        $publicationRow = null;

        try {
            $publicationRow = $this->getByUuidPublicationQuery->execute($uuid);
        } catch (Exception $e) {
            throw new Exception("unable to get publication by uuid");
        }

        if (!$publicationRow->success) {
            throw new Exception("publication not found");
        }

        // add authors
        foreach ($authorRows as $ar) {
            $this->storePublicationAuthorCommand->execute(new StorePublicationAuthorCommandInput(
                $ar->id,
                $publicationRow->id
            ));
        }

        // add tags
        foreach ($tagRows as $tr) {
            $this->storePublicationTagCommand->execute(new StorePublicationTagCommandInput(
                $publicationRow->id,
                $tr->id
            ));
        }
    }
}
