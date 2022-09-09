<?php

namespace App\Slices\User\UseCase;

use App\Slices\User\Domain\IGetAllUserQuery;
use Exception;

class GetAllUserResponseItem
{
    public function __construct(
        public string $uuid,
        public string $role,
        public string $name
    ) {
    }
}

interface IGetAllUserUseCase
{
    public function execute(): array;
}

class GetAllUserUseCase implements IGetAllUserUseCase
{
    public function __construct(
        private IGetAllUserQuery $getAllUserQuery
    ) {
    }

    public function execute(): array
    {
        try {
            $rows = $this->getAllUserQuery->execute();
            $response = [];
            foreach ($rows as $row) {
                $response[] = new GetAllUserResponseItem(
                    $row->uuid,
                    $row->role,
                    $row->name
                );
            }
            return $response;
        } catch (Exception $e) {
            throw new Exception("unable to get all users");
        }
    }
}
