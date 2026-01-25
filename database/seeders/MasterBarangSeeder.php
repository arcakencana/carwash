<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\MasterBarang;

class MasterBarangSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nama'          => 'BODY WASH SMALL',
                'harga_modal'   => '50000',
                'harga_jual'    => '50000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'BODY WASH LARGE',
                'harga_modal'   => '60000',
                'harga_jual'    => '60000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'BASIC WASH SMALL',
                'harga_modal'   => '70000',
                'harga_jual'    => '70000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'BASIC WASH LARGE',
                'harga_modal'   => '80000',
                'harga_jual'    => '80000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'PREMIUM WASH SMALL',
                'harga_modal'   => '100000',
                'harga_jual'    => '100000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'PREMIUM WASH LARGE',
                'harga_modal'   => '110000',
                'harga_jual'    => '110000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'PREMIUM WASH PLUS SMALL',
                'harga_modal'   => '150000',
                'harga_jual'    => '150000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'PREMIUM WASH PLUS LARGE',
                'harga_modal'   => '160000',
                'harga_jual'    => '160000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'ENGINE CLEANING',
                'harga_modal'   => '150000',
                'harga_jual'    => '150000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'CAR FOGGING',
                'harga_modal'   => '50000',
                'harga_jual'    => '50000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'MOTOR MATIC & BEBEK',
                'harga_modal'   => '20000',
                'harga_jual'    => '20000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'MOTOR SPORT 150 & 200CC',
                'harga_modal'   => '30000',
                'harga_jual'    => '30000',
                'kategori'      => 'primary',
            ],
            [
                'nama'          => 'MOTOR 250CC UP',
                'harga_modal'   => '50000',
                'harga_jual'    => '50000',
                'kategori'      => 'primary',
            ],
        ];

        foreach ($items as $data) {
            MasterBarang::firstOrCreate(
                ['nama' => $data['nama']],
                [
                    'harga_modal'   => $data['harga_modal'],
                    'harga_jual'    => $data['harga_jual'],
                    'kategori'      => $data['kategori'],
                ]
            );
        }
    }
}
