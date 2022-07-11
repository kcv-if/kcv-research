<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PublicationTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('publication_tags')->insert([
            ['publication_id' => 1, 'tag_id' => 1],
            ['publication_id' => 1, 'tag_id' => 2],
            ['publication_id' => 1, 'tag_id' => 3],
            ['publication_id' => 1, 'tag_id' => 4],
            ['publication_id' => 2, 'tag_id' => 1],
            ['publication_id' => 2, 'tag_id' => 2],
            ['publication_id' => 2, 'tag_id' => 4],
            ['publication_id' => 3, 'tag_id' => 1],
            ['publication_id' => 3, 'tag_id' => 3],
            ['publication_id' => 3, 'tag_id' => 4],
        ]);
    }
}
