<?php

use Illuminate\Database\Seeder;

class NewspaperslistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
         DB::table('newspaperslist')->insert([
             [
                'name' => 'Hindustan Times',
                'language_id' => 23
             ],
             [
                 'name' => 'Indian Express',
                'language_id' => 23
             ],
             [
                'name' => 'Statesman',
                'language_id' => 23
             ],
             [
                'name' => 'Times of India',
                'language_id' => 23
             ],
             [
                'name' => 'National Herald',
                'language_id' => 23
             ],
             [
                'name' => 'Hindustan',
                'language_id' => 6
             ],
             [
                'name' => 'Nav Bharat Times',
                'language_id' => 6
             ],
             [
                'name' => 'Vir Arjun',
                'language_id' => 6
             ],
             [
                'name' => 'Milap',
                'language_id' => 22
             ],
             [
                'name' => 'Pratap',
                'language_id' => 22
             ],
             [
               'name' => 'Tej',
                'language_id' => 22
             ],
             [
                'name' => 'Bande Matram',
                'language_id' => 6
             ],
             [
                 'name' => 'Vyapar Bharti',
                'language_id' => 6
             ],
              [
               'name' => 'The Educator',
                'language_id' => 16
             ],
             [
                'name' => 'Quami Awaz',
                'language_id' => 22
             ],
             [
                 'name' => 'Mid Day',
                'language_id' => 23
             ],
             [
                'name' => 'Pracheen Times',
                'language_id' => 22
             ],
             [
                 'name' => 'Indian Post',
                'language_id' => 23
             ]

        ]);
       
    }
}
