<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Client::class, 10)->create()->each(function ($client) {
            foreach (range(1,20) as $v) {
                $client->addresses()->save(factory(\App\Address::class)->make());
            }
        });
    }
}
