<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MitraSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 50; $i++) {
            DB::table('masterMitra')->insert([
                'namaMitra' => $faker->company,
                'alamatMitra' => $faker->address,
                'noTelp' => $faker->phoneNumber,
                'namaPic' => $faker->name,
                'tanggalBergabung' => $faker->date(),
                'status' => 'Aktif',
            ]);
        }
    }
}
