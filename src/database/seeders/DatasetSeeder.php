<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Ramsey\Uuid\Uuid;

class DatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('datasets')->insert([
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Human Face Collection',
                'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!',
                'download_link' => 'https://www.google.com/',
                'status' => 'p',
            ],
            [
                'uuid' => Uuid::uuid4(),
                'name' => 'Twitter Post Database',
                'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!',
                'download_link' => 'https://www.google.com/',
                'status' => 'p',
            ]
        ]);
    }
}
