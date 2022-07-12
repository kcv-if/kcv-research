<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class UserPublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_publications')->insert([
            ['user_id' => 2, 'publication_id' => 1, 'is_review' => false, 'review_comment' => null, 'reviewed_at' => null],
            ['user_id' => 3, 'publication_id' => 1, 'is_review' => false, 'review_comment' => null, 'reviewed_at' => null],
            ['user_id' => 1, 'publication_id' => 1, 'is_review' => true, 'review_comment' => "Very Good", 'reviewed_at' => Carbon::now()],
        ]);
    }
}
