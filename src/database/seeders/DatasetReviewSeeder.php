<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatasetReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dataset_reviews')->insert([
            ['user_id' => 1, 'dataset_id' => 1, 'comment' => "Very Good", 'created_at' => Carbon::now()],
        ]);
    }
}
