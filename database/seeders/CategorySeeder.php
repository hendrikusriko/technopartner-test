<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'type' => 'pemasukan',
                'name' => 'gaji',
                'desc' => 'lorem ipsum dolor sit amet',
            ],
            [
                'type' => 'pemasukan',
                'name' => 'tunjangan',
                'desc' => 'lorem ipsum dolor sit amet',
            ],
            [
                'type' => 'pemasukan',
                'name' => 'bonus',
                'desc' => 'lorem ipsum dolor sit amet',
            ],
            [
                'type' => 'pengeluaran',
                'name' => 'bayar listrik',
                'desc' => 'lorem ipsum dolor sit amet',
            ],
            [
                'type' => 'pengeluaran',
                'name' => 'sewa kos',
                'desc' => 'lorem ipsum dolor sit amet',
            ],
            [
                'type' => 'pengeluaran',
                'name' => 'makan',
                'desc' => 'lorem ipsum dolor sit amet',
            ],

        ];
        DB::table('category')->insert($data);
    }
}
