<?php

use Illuminate\Database\Seeder;

class MagazinelistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('magazinelists')->insert([
             [
                'name' => 'Grihshobha'
             ],
             [
                'name' => 'Womans Era'
             ],
             [
                'name' => 'Sarita'
             ],
             [
                'name' => 'Champak'
             ],
             [
                'name' => 'Saras Salil'
             ],
             [
                'name' => 'Mukta'
                
             ],
             [
                'name' => 'Suman Saurabh'
                
             ],
             [
                'name' => 'Farm N Food'
                
             ],
             [
                'name' => 'Manohar Kahaniyan',
               
             ],
             [
                'name' => 'Satyakatha',
               
             ],
             [
               'name' => 'Manasa',
               
             ],
             [
                'name' => 'Butti',
                
             ],
             [
                 'name' => 'Highlights Champs',
                
             ],
              [
               'name' => 'Highlights Genies',
                
             ],
             [
                'name' => 'Alive',
               
             ],
             [
                 'name' => 'The Caravan',
               
             ],
             [
                'name' => 'Motoring World',
               
             ],
             [
                 'name' => 'Tehelka',
              
             ]

        ]);
    }
}