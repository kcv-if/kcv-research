<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PublicationAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('publication_authors')->insert([
            ['user_id' => 2, 'publication_id' => 1],
            ['user_id' => 3, 'publication_id' => 1],
        ]);
    }
}
