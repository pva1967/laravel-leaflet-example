<?php

use Illuminate\Database\Seeder;


class InstnamesTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('instnames')->insert([
            ['name_en' => 'JSCC RAS', 'name_ru' => 'МСЦ РАН'],
            ['name_en' => 'SPbD JSCC RAS', 'name_ru' => 'СПбО МСЦ РАН'],
            ['name_en' => 'Tomsk Polytechnic University', 'name_ru' => 'Томский Политехнческий Университет '],
            ['name_en' => 'University MISIS', 'name_ru' => 'Университет МИСИС'],
            ['name_en' => 'Petrozavodsk State University', 'name_ru' => 'Петрозаводский государственный университет'],
            ['name_en' => 'Samara University', 'name_ru' => 'Самарский университет'],
            ['name_en' => 'ITMO University', 'name_ru' => 'Университет ИТМО'],
            ['name_en' => 'Joint Institute for Nuclear Research', 'name_ru' => 'ОИЯИ'],
            ['name_en' => 'DHI Moskau', 'name_ru' => 'Германский исторический институт'],
            ['name_en' => 'Novosibirsk State University', 'name_ru' => 'Новосибирский государственный университет'],
            ['name_en' => 'New Economic School', 'name_ru' => 'Новая экономическая школа'],
            ['name_en' => 'Institute for Theoretical Physics RAS', 'name_ru' => 'Институт теоретической физики РАН'],
            ['name_en'=>'Altai State Universty',	'name_ru'=>'Алтайский государственный университет'],
            ['name_en' => 'Ural Federal University', 'name_ru' => 'Уральский федеральный университет'],
            ['name_en' => 'South Ural State University ', 'name_ru' => 'Южно-Уральский государственный университет'],
            ['name_en' => 'Institute for High Energy Physics', 'name_ru' => 'Институт физики высоких энергий'],
            ['name_en' => 'Higher School of Economics', 'name_ru' => 'Высшая школа экономики']


        ]);

    }
}
