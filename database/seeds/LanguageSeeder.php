<?php

use App\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'name' => 'English (US)',
            'code' => 'en_US',
            'flag' => 'us',
            'plural_forms' => Language::PLURAL_FORM_ONE | Language::PLURAL_FORM_OTHER,
        ]);

        DB::table('languages')->insert([
            'name' => 'English (UK)',
            'code' => 'en_UK',
            'flag' => 'gb-eng',
            'plural_forms' => Language::PLURAL_FORM_ONE | Language::PLURAL_FORM_OTHER,
        ]);

        DB::table('languages')->insert([
            'name' => 'Polish',
            'code' => 'pl_PL',
            'flag' => 'pl',
            'plural_forms' => Language::PLURAL_FORM_ONE | Language::PLURAL_FORM_FEW | Language::PLURAL_FORM_MANY,
        ]);

        DB::table('languages')->insert([
            'name' => 'Spanish',
            'code' => 'es_ES',
            'flag' => 'es',
            'plural_forms' => Language::PLURAL_FORM_ONE | Language::PLURAL_FORM_OTHER,
        ]);
    }
}
