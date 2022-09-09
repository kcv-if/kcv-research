<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            TagSeeder::class,
            PublicationSeeder::class,
            DatasetSeeder::class,
            PublicationTagSeeder::class,
            DatasetTagSeeder::class,
            DatasetAuthorSeeder::class,
            DatasetReviewSeeder::class,
            PublicationAuthorSeeder::class,
            PublicationReviewSeeder::class,
        ]);
    }
}
