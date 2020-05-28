<?php

use Arbify\Models\Language;
use Arbify\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFewFlagsAndDefaultAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (app()->runningUnitTests()) {
            return;
        }

        DB::table('languages')->insertOrIgnore([
            [
                'name' => 'English',
                'code' => 'en',
                'flag' => 'united-kingdom',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'name' => 'Polish',
                'code' => 'pl',
                'flag' => 'poland',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY
                ),
            ],
            [
                'name' => 'Spanish',
                'code' => 'es',
                'flag' => 'spain',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
        ]);

        DB::table('users')->insertOrIgnore([
            'name' => 'admin',
            'email' => 'admin@arbify.io',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => User::ROLE_SUPER_ADMINISTRATOR,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('languages')->whereIn('code', ['en', 'pl', 'es'])->delete();
        DB::table('users')->where('email', 'admin@arbify.io')->delete();
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
