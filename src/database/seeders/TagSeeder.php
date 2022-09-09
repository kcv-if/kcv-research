<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Ramsey\Uuid\Uuid;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'machine_learning'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'computer_vision'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'natural_language_processing'
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'deep_learning'
            ]
        ]);
    }
}
