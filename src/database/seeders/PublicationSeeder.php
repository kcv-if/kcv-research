<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class PublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('publications')->insert([
            [
                'name' => 'Introduction to Machine Learning',
                'excerpt' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!',
                'abstract' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!',
                'download_link' => 'https://www.google.com/',
                'status' => 'p',
                'slug' => 'introduction-to-machine-learning'
            ],
            [
                'name' => 'Review on Face Detection Algorithms',
                'excerpt' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!',
                'abstract' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!',
                'download_link' => 'https://www.google.com/',
                'status' => 'p',
                'slug' => 'review-on-face-detection-algorithms'
            ],
            [
                'name' => 'Sentiment Analysis on Twitter Posts',
                'excerpt' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!',
                'abstract' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae fugiat possimus cupiditate et unde rerum error doloribus at reprehenderit, aliquam ab ea asperiores minima recusandae? Dolore inventore culpa porro accusantium!',
                'download_link' => 'https://www.google.com/',
                'status' => 'p',
                'slug' => 'sentiment-analysis-on-twitter-posts'
            ],
        ]);
    }
}
