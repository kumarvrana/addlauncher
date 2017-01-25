<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new \App\Product([
            'imagepath' => 'http://bensbargains.com/thecheckout/wp-content/uploads/2013/06/modern-day-iron-man-time-cover.jpg',
            'title' => 'Title 1',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown',
            'price' => 120
        ]);

        $product->save();

        $product = new \App\Product([
            'imagepath' => 'http://bensbargains.com/thecheckout/wp-content/uploads/2013/06/modern-day-iron-man-time-cover.jpg',
            'title' => 'Title 2',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown',
            'price' => 120
        ]);

        $product->save();

        $product = new \App\Product([
            'imagepath' => 'http://bensbargains.com/thecheckout/wp-content/uploads/2013/06/modern-day-iron-man-time-cover.jpg',
            'title' => 'Title 3',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown',
            'price' => 120
        ]);

        $product->save();

        $product = new \App\Product([
            'imagepath' => 'http://bensbargains.com/thecheckout/wp-content/uploads/2013/06/modern-day-iron-man-time-cover.jpg',
            'title' => 'Title 4',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown',
            'price' => 120
        ]);

        $product->save();

        $product = new \App\Product([
            'imagepath' => 'http://bensbargains.com/thecheckout/wp-content/uploads/2013/06/modern-day-iron-man-time-cover.jpg',
            'title' => 'Title 5',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown',
            'price' => 120
        ]);

        $product->save();
        $product = new \App\Product([
            'imagepath' => 'http://bensbargains.com/thecheckout/wp-content/uploads/2013/06/modern-day-iron-man-time-cover.jpg',
            'title' => 'Title 6',
            'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown',
            'price' => 120
        ]);

        $product->save();
    }
}
