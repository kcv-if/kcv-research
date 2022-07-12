<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UserDatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_datasets')->insert([
            ['user_id' => 2, 'dataset_id' => 1, 'is_review' => false],
            ['user_id' => 3, 'dataset_id' => 1, 'is_review' => false],
            ['user_id' => 1, 'dataset_id' => 1, 'is_review' => true],
        ]);
    }
}
