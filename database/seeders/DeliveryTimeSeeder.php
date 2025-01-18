<?php

namespace Database\Seeders;

use App\Models\DeliveryTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $times = [
            'NOW',
            '10.00',
            '10.30',
            '11.00',
            '11.30',
            '12.00',
            '12.30',
            '13.00',
            '13.30',
            '14.00',
            '14.30',
            '15.00',
            '15.30',
            '16.00',
            '16.30',
            '17.00',
            '17.30',
            '18.00',
            '18.30',
            '19.00',
            '19.30',
            '20.00',
            '20.30',
            '21.00',
            '21.30',
            '22.00',
            '22.30',
            '23.00'
        ];

        foreach ($times as $time) {
            $description = ($time === 'NOW') ? 'Dikirim sekarang' : "Dikirim pukul $time";
            DeliveryTime::create([
                'name' => $time,
                'description' => $description
            ]);
        }
    }
}
