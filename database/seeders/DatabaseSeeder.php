<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\RekeningAdmin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Bank::create([
            'nama_bank' => 'BCA',
            'kode_bank' => 'BCA',
        ]);

        Bank::create([
            'nama_bank' => 'BRI',
            'kode_bank' => 'BRI',
        ]);

        Bank::create([
            'nama_bank' => 'Mandiri',
            'kode_bank' => 'Mandiri',
        ]);

        RekeningAdmin::create([
            'bank_id' => 1,
            'nomor_rekening' => '1111',
            'nama_pemilik' => 'Rekening 1',
        ]);

        RekeningAdmin::create([
            'bank_id' => 2,
            'nomor_rekening' => '222',
            'nama_pemilik' => 'Rekening 2',
        ]);

        RekeningAdmin::create([
            'bank_id' => 3,
            'nomor_rekening' => '333',
            'nama_pemilik' => 'Rekening 3',
        ]);
    }
}
