<?php

use Illuminate\Database\Seeder;

class ProxiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('proxies')->insert([
            ['inst_id' => 1, 'ip' => '83.149.214.22'],
            ['inst_id' => 1, 'ip' => '83.149.214.121' ],
            ['inst_id' => 4, 'ip' => '85.143.104.211'],
            ['inst_id' => 5, 'ip' => '193.232.254.3'],
            ['inst_id' => 11,'ip' => '83.69.196.162'],
            ['inst_id' => 10, 'ip' => '84.237.50.80'],
            ['inst_id' => 10, 'ip' => '84.237.50.180'],
            ['inst_id' => 9,'ip' => '89.175.12.34'],
            ['inst_id' => 2,'ip' => '85.142.29.235']

        ]);
    }
}
