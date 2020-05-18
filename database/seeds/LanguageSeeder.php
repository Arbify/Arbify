<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('languages')->insert([
            [
                'name' => 'English',
                'code' => 'en',
                'flag' => 'us',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE, Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'name' => 'Polish',
                'code' => 'pl',
                'flag' => 'pl',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE, Language::PLURAL_FORM_FEW, Language::PLURAL_FORM_MANY
                ),
            ],
            [
                'name' => 'Spanish',
                'code' => 'es',
                'flag' => 'es',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE, Language::PLURAL_FORM_OTHER
                ),
            ],
        ]);
    }

    private function pluralFormsFormat(string ...$forms): int
    {
        $result = 0;
        foreach ($forms as $form) {
            $result |= Language::PLURAL_FORMS[$form];
        }

        return $result;
    }
}
