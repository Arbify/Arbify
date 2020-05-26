<?php

use App\Models\Language;
use Illuminate\Database\Migrations\Migration;

class AddMajorityOfLanguages extends Migration
{
    public function up(): void
    {
        DB::table('languages')
            ->where('code', 'en')
            ->update([
                'flag' => 'united-kingdom',
            ]);

        DB::table('languages')
            ->where('code', 'pl')
            ->update([
                'flag' => 'poland',
            ]);

        DB::table('languages')
            ->where('code', 'es')
            ->update([
                'flag' => 'spain',
            ]);

        DB::table('languages')->insertOrIgnore([
            [
                'code' => 'af',
                'name' => 'Afrikaans',
                'flag' => null,
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ak',
                'name' => 'Akan',
                'flag' => 'ghana',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'sq',
                'name' => 'Albanian',
                'flag' => 'albania',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'am',
                'name' => 'Amharic',
                'flag' => 'ethiopia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ar',
                'name' => 'Arabic',
                'flag' => 'saudi-arabia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ZERO,
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_TWO,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'an',
                'name' => 'Aragonese',
                'flag' => 'spain',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'hy',
                'name' => 'Armenian',
                'flag' => 'armenia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'as',
                'name' => 'Assamese',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'az',
                'name' => 'Azerbaijani',
                'flag' => 'azerbaijan',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'mb',
                'name' => 'Bambara',
                'flag' => 'mali',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'bn',
                'name' => 'Bangla',
                'flag' => 'bangladesh',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'eu',
                'name' => 'Basque',
                'flag' => 'basque-country',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'be',
                'name' => 'Belarusian',
                'flag' => 'belarus',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'bs',
                'name' => 'Bosnian',
                'flag' => 'bosnia-and-herzegovina',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'br',
                'name' => 'Breton',
                'flag' => 'france',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_TWO,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'bg',
                'name' => 'Bulgarian',
                'flag' => 'bulgaria',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'my',
                'name' => 'Burmese',
                'flag' => 'myanmar',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ca',
                'name' => 'Catalan',
                'flag' => 'spain',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ce',
                'name' => 'Chechen',
                'flag' => null,
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'zh-CN',
                'name' => 'Simplified Chinese',
                'flag' => 'china',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'zh-TW',
                'name' => 'Traditional Chinese',
                'flag' => 'taiwan',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'kw',
                'name' => 'Cornish',
                'flag' => 'england',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ZERO,
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_TWO,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'hr',
                'name' => 'Croatian',
                'flag' => 'croatia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'cs',
                'name' => 'Czech',
                'flag' => 'czech-republic',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'da',
                'name' => 'Danish',
                'flag' => 'denmark',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'dv',
                'name' => 'Divehi',
                'flag' => 'maldives',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'nl',
                'name' => 'Dutch',
                'flag' => 'netherlands',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'dz',
                'name' => 'Dzonghka',
                'flag' => 'bhutan',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'en',
                'name' => 'English',
                'flag' => 'united-kingdom',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'eo',
                'name' => 'Esperanto',
                'flag' => null,
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'et',
                'name' => 'Estonian',
                'flag' => 'estonia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ee',
                'name' => 'Ewe',
                'flag' => 'ghana',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'fo',
                'name' => 'Faroese',
                'flag' => 'faroe-islands',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'fi',
                'name' => 'Finnish',
                'flag' => 'finland',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'fr',
                'name' => 'French',
                'flag' => 'france',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ff',
                'name' => 'Fulah',
                'flag' => null,
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'gl',
                'name' => 'Galician',
                'flag' => 'spain',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'lg',
                'name' => 'Ganda',
                'flag' => 'uganda',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ka',
                'name' => 'Georgian',
                'flag' => 'georgia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'de',
                'name' => 'German',
                'flag' => 'germany',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'el',
                'name' => 'Greek',
                'flag' => 'greece',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'gu',
                'name' => 'Gujarati',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ha',
                'name' => 'Hausa',
                'flag' => 'niger',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'hi',
                'name' => 'Hindi',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'hu',
                'name' => 'Hungarian',
                'flag' => 'hungary',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'is',
                'name' => 'Icelandic',
                'flag' => 'iceland',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ig',
                'name' => 'Igbo',
                'flag' => 'nigeria',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'id',
                'name' => 'Indonesian',
                'flag' => 'indonesia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'iu',
                'name' => 'Inuktitut',
                'flag' => 'greenland',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_TWO,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ga',
                'name' => 'Irish',
                'flag' => 'ireland',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_TWO,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'it',
                'name' => 'Italian',
                'flag' => 'italy',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ja',
                'name' => 'Japanese',
                'flag' => 'japan',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'jv',
                'name' => 'Javanese',
                'flag' => 'indonesia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'kl',
                'name' => 'Kalaallisut',
                'flag' => 'greenland',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'kn',
                'name' => 'Kannada',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ks',
                'name' => 'Kashmiri',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'kk',
                'name' => 'Kazakh',
                'flag' => 'kazakhstan',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'km',
                'name' => 'Khmer',
                'flag' => 'cambodia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ko',
                'name' => 'Korean',
                'flag' => 'south-korea',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ku',
                'name' => 'Kurdish',
                'flag' => 'turkey',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ky',
                'name' => 'Kyrgyz',
                'flag' => 'kyrgyzstan',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'lo',
                'name' => 'Lao',
                'flag' => 'laos',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'lv',
                'name' => 'Latvian',
                'flag' => 'latvia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ZERO,
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ln',
                'name' => 'Lingala',
                'flag' => 'democratic-republic-of-congo',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'lt',
                'name' => 'Lithuanian',
                'flag' => 'lithuania',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'lb',
                'name' => 'Luxembourgish',
                'flag' => 'luxembourg',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'mk',
                'name' => 'Macedonian',
                'flag' => 'republic-of-macedonia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'mg',
                'name' => 'Malagasy',
                'flag' => 'madagascar',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ms',
                'name' => 'Malay',
                'flag' => 'malaysia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ml',
                'name' => 'Malayalam',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'mt',
                'name' => 'Maltese',
                'flag' => 'malta',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'gv',
                'name' => 'Manx',
                'flag' => 'isle-of-man',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_TWO,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'mr',
                'name' => 'Marathi',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'mn',
                'name' => 'Mongolian',
                'flag' => 'mongolia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ne',
                'name' => 'Nepali',
                'flag' => 'nepal',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'nd',
                'name' => 'North Ndebele',
                'flag' => 'zimbabwe',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'se',
                'name' => 'Northern Sami',
                'flag' => 'norway',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_TWO,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'no',
                'name' => 'Norwegian',
                'flag' => 'norway',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'nn',
                'name' => 'Norwegian Nynorsk',
                'flag' => 'norway',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ny',
                'name' => 'Nyanja',
                'flag' => 'malawi',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'or',
                'name' => 'Odia',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'om',
                'name' => 'Oromo',
                'flag' => 'ethiopia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'os',
                'name' => 'Ossetic',
                'flag' => 'ossetia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ps',
                'name' => 'Pashto',
                'flag' => 'afghanistan',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'fa',
                'name' => 'Persian',
                'flag' => 'iran',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'pl',
                'name' => 'Polish',
                'flag' => 'poland',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'pt',
                'name' => 'Portuguese',
                'flag' => 'portugal',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'pa',
                'name' => 'Punjabi',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ro',
                'name' => 'Romanian',
                'flag' => 'romania',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'rm',
                'name' => 'Romansh',
                'flag' => 'switzerland',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ru',
                'name' => 'Russian',
                'flag' => 'russia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'sg',
                'name' => 'Sango',
                'flag' => 'central-african-republic',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'sc',
                'name' => 'Sardinian',
                'flag' => 'italy',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'gd',
                'name' => 'Scottish Gaelic',
                'flag' => 'scotland',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_TWO,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'sr',
                'name' => 'Serbian',
                'flag' => 'serbia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'sn',
                'name' => 'Shona',
                'flag' => 'zimbabwe',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ii',
                'name' => 'Sichuan Yi',
                'flag' => 'china',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'sd',
                'name' => 'Sindhi',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'si',
                'name' => 'Sinhala',
                'flag' => 'sri-lanka',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'sk',
                'name' => 'Slovak',
                'flag' => 'slovakia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'sl',
                'name' => 'Slovenian',
                'flag' => 'slovenia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_TWO,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'so',
                'name' => 'Somali',
                'flag' => 'somalia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'nr',
                'name' => 'South Ndebele',
                'flag' => 'south-africa',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'st',
                'name' => 'Southern Sotho',
                'flag' => 'lesotho',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'es',
                'name' => 'Spanish',
                'flag' => 'spain',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'su',
                'name' => 'Sundanese',
                'flag' => 'indonesia',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'sw',
                'name' => 'Swahili',
                'flag' => 'tanzania',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ss',
                'name' => 'Swati',
                'flag' => 'south-africa',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'sv',
                'name' => 'Swedish',
                'flag' => 'sweden',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ta',
                'name' => 'Tamil',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'te',
                'name' => 'Telugu',
                'flag' => 'india',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'th',
                'name' => 'Thai',
                'flag' => 'thailand',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'bo',
                'name' => 'Tibetan',
                'flag' => 'china',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ti',
                'name' => 'Tigrinya',
                'flag' => 'eritrea',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'to',
                'name' => 'Tongan',
                'flag' => 'tonga',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ts',
                'name' => 'Tsonga',
                'flag' => 'south-africa',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'tn',
                'name' => 'Tswana',
                'flag' => 'botswana',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'tr',
                'name' => 'Turkish',
                'flag' => 'turkey',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'tk',
                'name' => 'Turkmen',
                'flag' => 'turkmenistan',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'uk',
                'name' => 'Ukrainian',
                'flag' => 'ukraine',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ur',
                'name' => 'Urdu',
                'flag' => 'pakistan',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'ug',
                'name' => 'Uyghur',
                'flag' => 'china',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'uz',
                'name' => 'Uzbek',
                'flag' => 'uzbekistn',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 've',
                'name' => 'Venda',
                'flag' => 'south-africa',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'vi',
                'name' => 'Vietnamese',
                'flag' => 'vietnam',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'wa',
                'name' => 'Walloon',
                'flag' => 'belgium',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'cy',
                'name' => 'Welsh',
                'flag' => 'wales',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ZERO,
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_TWO,
                    Language::PLURAL_FORM_FEW,
                    Language::PLURAL_FORM_MANY,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'fy',
                'name' => 'Western Frisian',
                'flag' => 'netherlands',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'wo',
                'name' => 'Wolof',
                'flag' => 'senegal',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'xh',
                'name' => 'Xhosa',
                'flag' => 'south-africa',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'yi',
                'name' => 'Yiddish',
                'flag' => null,
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'yo',
                'name' => 'Yoruba',
                'flag' => 'nigeria',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_OTHER
                ),
            ],
            [
                'code' => 'zu',
                'name' => 'Zulu',
                'flag' => 'south-africa',
                'plural_forms' => $this->pluralFormsFormat(
                    Language::PLURAL_FORM_ONE,
                    Language::PLURAL_FORM_OTHER
                ),
            ],
        ]);
    }

    public function down(): void
    {
        //
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
