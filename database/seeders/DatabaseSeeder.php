<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Jurusan::create(
            [
                'nama' => 'Teknik Informatika',
                'kepala_jurusan' => 'Dr. Safir Anam, M.Kom.',
                'daya_tampung' => 100,
            ]
        );

        Jurusan::create(
            [
                'nama' => 'Teknik Mesin',
                'kepala_jurusan' => 'Ir. Anam, M.Kom.',
                'daya_tampung' => 140,
            ]
        );

        Jurusan::create(
            [
                'nama' => 'Teknik Industri',
                'kepala_jurusan' => 'H. Diki, M.Kom.',
                'daya_tampung' => 300,
            ]
        );
        Jurusan::create(
            [
                'nama' => 'Teknik Sipil',
                'kepala_jurusan' => 'Dr. Soekarno M.Kom.',
                'daya_tampung' => 200,
            ]
        );

        $faker = \Faker\Factory::create('id_ID');
        $faker->seed(123);

        for ($i = 0; $i < 10; $i++) {
            \App\Models\Mahasiswa::create([
                'nama' => $faker->name,
                'nim' => $faker->unique()->numerify( '10######'),
                'jurusan_id' => $faker->numberBetween(1, 3),
            ]);
        }

    }
}
