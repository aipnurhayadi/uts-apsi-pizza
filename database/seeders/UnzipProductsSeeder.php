<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use ZipArchive;

class UnzipProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $zipFile = base_path('assets/products.zip');
        $destinationFolder = storage_path('app/public');

        if (!file_exists($zipFile)) {
            $this->command->error("ZIP file not found: $zipFile");
            return;
        }

        if (!is_dir($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipFile) === TRUE) {

            $zip->extractTo($destinationFolder);
            $zip->close();
            $this->command->info("Files extracted to $destinationFolder");
        } else {
            $this->command->error("Failed to open ZIP file: $zipFile");
        }
    }
}
