<?php

namespace App\Slices\User\Repository\MySql;

use App\Slices\User\Domain\IUpdateUserCommand;
use App\Slices\User\Domain\UpdateUserCommandInput;
use Illuminate\Support\Facades\DB;

class MySqlUpdateUserCommand implements IUpdateUserCommand
{
    public function execute(UpdateUserCommandInput $input): void
    {
        DB::update(
            "UPDATE users
            SET
                name = ?,
                email = ?,
                password = ?,
                telephone = ?,
                updated_at = ?
            WHERE id = ?",
            [
                $input->name,
                $input->email,
                $input->password,
                $input->telephone,
                $input->updatedAt,
                $input->id
            ]
        );
    }
}
