<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'uuid' => Uuid::uuid4(),
                'role' => 'a',
                'name' => 'Admin 1',
                'email' => 'admin1@mail.com',
                'password' => Hash::make('admin1'),
                'telephone' => '1234567890',
            ],
            [
                'uuid' => Uuid::uuid4(),
                'role' => 'u',
                'name' => 'User 1',
                'email' => 'user1@mail.com',
                'password' => Hash::make('user1'),
                'telephone' => '1234567890',
            ],
            [
                'uuid' => Uuid::uuid4(),
                'role' => 'u',
                'name' => 'User 2',
                'email' => 'user2@mail.com',
                'password' => Hash::make('user2'),
                'telephone' => '1234567890',
            ],
        ]);
    }
}
