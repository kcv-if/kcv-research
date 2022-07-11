<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

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
            ['name' => 'machine_learning'],
            ['name' => 'computer_vision'],
            ['name' => 'natural_language_processing'],
            ['name' => 'deep_learning']
        ]);
    }
}
