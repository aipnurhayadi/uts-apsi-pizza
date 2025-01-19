<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use App\Models\ProductCrust;
use App\Models\ProductSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category' => 'pizza',
                'name' => 'Vegie Garden',
                'description' => 'Jamur, paprika merah & hijau, nanas, jagung dan keju mozzarella',
                'price' => 100000.00,
            ],
            [
                'category' => 'pizza',
                'name' => 'Super Supreme',
                'description' => 'Daging Sapi Asap, Daging Ayam Asap, Burger Sapi, Jamur, Nanas, Paprika dan Keju Mozzarella.',
                'price' => 100000.00,
            ],
            [
                'category' => 'pizza',
                'name' => 'Meat Lovers',
                'description' => 'Burger Sapi, Daging Sapi Cincang, Sosis Sapi, Sosis Ayam, Keju Mozzarella',
                'price' => 100000.00,
            ],
            [
                'category' => 'pizza',
                'name' => 'American Favourite',
                'description' => 'Pepperoni, beef topping, jamur, keju mozzarella, onion, saus pizza spesial.',
                'price' => 100000.00,
            ],
            [
                'category' => 'pasta_rice',
                'name' => "Mom's Spaghetti Bolognese",
                'description' => 'Spaghetti, Daging Sapi Cincang, Tomato Sauce, Keju Cheddar, Parsley.',
                'price' => 36364.00,
            ],
            [
                'category' => 'pasta_rice',
                'name' => 'Cheese Please Fusilli',
                'description' => 'Fusilli, Pepperoni, Keju Cheddar, Keju Mozzarella, Beef Bits, Parsley.',
                'price' => 40909.00,
            ],
            [
                'category' => 'pasta_rice',
                'name' => 'Mac Crunchy Chiz',
                'description' => 'Macaroni, Daging Sapi Asap, Keju Cheddar, Keju Mozzarella, Chili Mayo, Bechamel Sauce, Parsley, Crunchy Crumb.',
                'price' => 36364.00,
            ],
            [
                'category' => 'pasta_rice',
                'name' => 'Katsu Curry Me With You',
                'description' => 'Nasi, Chicken Katsu, Onion, Curry Sauce, Parsley.',
                'price' => 36364.00,
            ],
            [
                'category' => 'snack_drink',
                'name' => 'Beef Sausage Bites 5 Pcs',
                'description' => 'Sosis Sapi Panggang dan Saus Barbeque',
                'price' => 30000.00,
            ],
            [
                'category' => 'snack_drink',
                'name' => 'Mac n Cheese 6 Pcs',
                'description' => 'Pasta Makaroni, Daging Sapi Asap, Beef Bits dan Keju Mozzarella',
                'price' => 27273.00,
            ],
            [
                'category' => 'snack_drink',
                'name' => 'Coca Cola 250 ml',
                'description' => 'Coca Cola PET 250 ml',
                'price' => 9091.00,
            ],
            [
                'category' => 'snack_drink',
                'name' => 'Aqua 330 ml',
                'description' => 'Aqua 330 ml',
                'price' => 7723.00,
            ],
        ];

        $sizes = [
            ['name' => 'Personal', 'additional_price' => 0],
            ['name' => 'Regular', 'additional_price' => 25000],
            ['name' => 'Large', 'additional_price' => 35000],
        ];

        $crusts = [
            ['name' => 'Original', 'additional_price' => 10000],
            ['name' => 'Sausage', 'additional_price' => 10000],
            ['name' => 'Cheese', 'additional_price' => 10000],
        ];

        $images = [
            'vegie_garden',
            'super_supreme',
            'meat_lover',
            'american_favourite',
            'moms_spaghetti_bolognese',
            'cheese_please_fusilli',
            'mac_crunchy_chiz',
            'katsu_curry_me_with_you',
            'beef_sausage_bites_5_pcs',
            'mac_n_cheese_6_pcs',
            'coca_cola_250_ml',
            'aqua_330_ml',
        ];

        foreach ($products as $index => $productData) {
            $product = Product::create($productData);

            if ($product->category == 'pizza') {
                foreach ($sizes as $size) {
                    ProductSize::create([
                        'product_id' => $product->id,
                        'name' => $size['name'],
                        'description' => "Ukuran {$size['name']} untuk {$product->name}",
                        'additional_price' => $size['additional_price'],
                    ]);
                }

                foreach ($crusts as $crust) {
                    ProductCrust::create([
                        'product_id' => $product->id,
                        'name' => $crust['name'],
                        'description' => "Tambahan {$crust['name']} untuk {$product->name}",
                        'additional_price' => $crust['additional_price'],
                    ]);
                }
            }


            Image::create([
                'path' => "public/products/{$images[$index]}.png",
                'type' => 'image/png',
                'imageable_id' => $product->id,
                'imageable_type' => Product::class,
            ]);
        }
    }
}
