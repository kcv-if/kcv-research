<?php

namespace App\Slices\User\UseCase;

use App\Slices\User\Domain\IGetByUuidUserQuery;
use DateTime;
use Exception;

class GetByUuidUserResponse
{
    public function __construct(
        public string $uuid,
        public string $role,
        public string $name,
        public string $email,
        public string $password,
        public string $telephone,
        public DateTime $createdAt
    ) {
    }
}

interface IGetByUuidUserUseCase
{
    public function execute(string $uuid): GetByUuidUserResponse;
}

class GetByUuidUserUseCase implements IGetByUuidUserUseCase
{
    public function __construct(
        private IGetByUuidUserQuery $getByUuidUserQuery
    ) {
    }

    public function execute(string $uuid): GetByUuidUserResponse
    {
        $row = null;

        try {
            $row = $this->getByUuidUserQuery->execute($uuid);
        } catch (Exception $e) {
            throw new Exception("unable to get user by uuid");
        }

        if (!$row->success) {
            throw new Exception("user not found");
        }

        return new GetByUuidUserResponse(
            $row->uuid,
            $row->role,
            $row->name,
            $row->email,
            $row->password,
            $row->telephone,
            $row->createdAt
        );
    }
}
