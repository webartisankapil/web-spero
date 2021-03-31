<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $sizeArray  = ["s", "m", "l", "xl", "xxl"];
        $imageArray = [
          "blue-t-shirt.jpg",
          "bright-purple-t-shirt.jpg",
          "cobalt-blue-t-shirt.jpg",
          "green-t-shirt.jpg",
          "purple-t-shirt.jpg",
          "red-t-shirt.jpg",
      ];

        foreach (range(1,60) as $key => $value) {
          $sizeKey  = array_rand($sizeArray);
          $imageKey = array_rand($imageArray);
          $stock    = $faker->boolean;

          Product::create([
            'image_url' => 'images/'.$imageArray[$imageKey],
            'size'      => $sizeArray[$sizeKey],
            'color'     => $faker->colorName,
            'instock'   => $stock,
            'quantity'  => $stock ? $faker->numberBetween($min = 1, $max = 10) : 0,
            'price'     => $faker->numberBetween($min = 100, $max = 1000),
          ]);
        }
    }
}
