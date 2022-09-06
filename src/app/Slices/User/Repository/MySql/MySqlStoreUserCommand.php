<?php

namespace App\Slices\User\Repository\MySql;

use App\Slices\User\Domain\IStoreUserCommand;
use App\Slices\User\Domain\StoreUserCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlStoreUserCommand implements IStoreUserCommand
{
    public function execute(StoreUserCommandInput $input): void
    {
        DB::insert(
            "INSERT INTO users (
                uuid,
                role,
                name,
                email,
                password,
                telephone,
                created_at
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?
            )",
            [
                $input->uuid,
                $input->role,
                $input->name,
                $input->email,
                $input->password,
                $input->telephone,
                $input->createdAt,
            ]
        );
    }
}
