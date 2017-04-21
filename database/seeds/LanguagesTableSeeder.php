<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $language = new \App\Language([
            'name' => 'Assamese'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Bengali'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Bodo'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Dogri'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Gujarati'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Hindi'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Kannada'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Kashmiri'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Konkani'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Maithili'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Malayalam'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Manipuri'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Marathi'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Nepali'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Odia'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Punjabi'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Sanskrit'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Santali'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Sindhi'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Tamil'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Telugu'
        ]);
        $language->save();
        $language = new \App\Language([
            'name' => 'Urdu'
        ]);
        $language->save();
    }
}
