<?php

namespace App\Slices\User\UseCase;

use App\Slices\User\Domain\IDeleteUserCommand;
use App\Slices\User\Domain\IGetByUuidUserQuery;
use Exception;

interface IDeleteUserUseCase
{
    public function execute(string $uuid): void;
}

class DeleteUserUseCase implements IDeleteUserUseCase
{
    public function __construct(
        private IGetByUuidUserQuery $getByUuidUserQuery,
        private IDeleteUserCommand $deleteUserCommand
    ) {
    }

    public function execute(string $uuid): void
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

        try {
            $this->deleteUserCommand->execute($row->id);
        } catch (Exception $e) {
            throw new Exception("unable to delete user");
        }
    }
}
