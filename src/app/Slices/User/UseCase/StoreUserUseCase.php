<?php

namespace App\Slices\User\UseCase;

use App\Slices\User\Domain\IStoreUserCommand;
use App\Slices\User\Domain\StoreUserCommandInput;
use App\Slices\User\Domain\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class StoreUserRequest
{
    public function __construct(
        public string $role,
        public string $name,
        public string $email,
        public string $password,
        public string $telephone,
    ) {
    }
}

interface IStoreUserUseCase
{
    public function execute(StoreUserRequest $request): void;
}

class StoreUserUseCase implements IStoreUserUseCase
{
    public function __construct(
        private IStoreUserCommand $storeUserCommand
    ) {
    }

    public function execute(StoreUserRequest $request): void
    {
        try {
            $user = new User(
                id: 0,
                uuid: Uuid::uuid4(),
                role: $request->role,
                name: $request->name,
                email: $request->email,
                password: Hash::make($request->password),
                telephone: $request->telephone,
                publications: [],
                publicationReviews: [],
                datasets: [],
                datasetReviews: [],
                createdAt: Carbon::now()
            );

            $this->storeUserCommand->execute(new StoreUserCommandInput(
                uuid: $user->getUuid(),
                role: $user->getRole(),
                name: $user->getName(),
                email: $user->getEmail(),
                password: $user->getPassword(),
                telephone: $user->getTelephone(),
                createdAt: $user->getCreatedAt()
            ));
        } catch (Exception $e) {
            throw new Exception("unable to store user");
        }
    }
}
