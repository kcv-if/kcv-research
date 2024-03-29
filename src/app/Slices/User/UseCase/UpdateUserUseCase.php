<?php

namespace App\Slices\User\UseCase;

use App\Slices\User\Domain\IGetByUuidUserQuery;
use App\Slices\User\Domain\IUpdateUserCommand;
use App\Slices\User\Domain\UpdateUserCommandInput;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;

class UpdateUserRequest
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $email,
        public ?string $password,
        public string $telephone
    ) {
    }
}

interface IUpdateUserUseCase
{
    public function execute(UpdateUserRequest $request): void;
}

class UpdateUserUseCase implements IUpdateUserUseCase
{
    public function __construct(
        private IGetByUuidUserQuery $getByUuidUserQuery,
        private IUpdateUserCommand $updateUserCommand
    ) {
    }

    public function execute(UpdateUserRequest $request): void
    {
        $row = null;

        try {
            $row = $this->getByUuidUserQuery->execute($request->uuid);
        } catch (Exception $e) {
            throw new Exception("unable to get user by uuid");
        }

        if (!$row->success) {
            throw new Exception("user not found");
        }

        try {
            $password = $request->password;

            if (!$password) {
                $password = $row->password;
            } else {
                $password = Hash::make($password);
            }

            $this->updateUserCommand->execute(new UpdateUserCommandInput(
                $row->id,
                $request->name,
                $request->email,
                $password,
                $request->telephone,
                Carbon::now()
            ));
        } catch (Exception $e) {
            throw new Exception("unable to update user");
        }
    }
}
