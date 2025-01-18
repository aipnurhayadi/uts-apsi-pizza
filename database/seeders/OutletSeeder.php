<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlets = [
            ['name' => 'PHD GANDAPURA', 'location' => 'PHD GANDAPURA', 'lat' => 0, 'long' => 0],
            ['name' => 'PHD KARAWITAN', 'location' => 'PHD KARAWITAN', 'lat' => 0, 'long' => 0],
            ['name' => 'PHD KEPATIHAN', 'location' => 'PHD KEPATIHAN', 'lat' => 0, 'long' => 0],
            ['name' => 'PHD PURWAKARTA', 'location' => 'PHD PURWAKARTA', 'lat' => 0, 'long' => 0],
            ['name' => 'PHD TERUSAN JAKARTA', 'location' => 'PHD TERUSAN JAKARTA', 'lat' => 0, 'long' => 0],
            ['name' => 'PHD TERUSAN JAKARTA', 'location' => 'PHD TERUSAN JAKARTA', 'lat' => 0, 'long' => 0],
        ];

        foreach ($outlets as $outlet) {
            Outlet::create($outlet);
        }
    }
}
