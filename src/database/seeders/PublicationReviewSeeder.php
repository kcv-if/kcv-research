<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Carbon;

class PublicationReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('publication_reviews')->insert([
            ['user_id' => 1, 'publication_id' => 1, 'comment' => "Very Good", 'created_at' => Carbon::now()],
        ]);
    }
}
