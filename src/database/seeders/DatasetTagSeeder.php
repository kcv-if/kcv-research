<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatasetTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dataset_tags')->insert([
            ['dataset_id' => 1, 'tag_id' => 2],
            ['dataset_id' => 2, 'tag_id' => 3],
        ]);
    }
}
