<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            [
                'name' => 'Bank Indonesia (Transfer Bank)',
                'description' => 'Pembayaran melalui transfer ke rekening bank di Indonesia seperti Bank Mandiri, BCA, BNI, dll.',
            ],
            [
                'name' => 'OVO',
                'description' => 'Pembayaran menggunakan aplikasi dompet digital OVO, salah satu e-wallet populer di Indonesia.',
            ],
            [
                'name' => 'GoPay',
                'description' => 'Pembayaran menggunakan layanan dompet digital GoPay yang terintegrasi dengan aplikasi Gojek.',
            ],
            [
                'name' => 'DANA',
                'description' => 'Pembayaran melalui dompet digital DANA yang dapat digunakan untuk berbagai transaksi online dan offline.',
            ],
            [
                'name' => 'LinkAja',
                'description' => 'Pembayaran menggunakan aplikasi LinkAja, yang dapat digunakan untuk berbagai jenis transaksi di Indonesia.',
            ],
        ]);
    }
}
