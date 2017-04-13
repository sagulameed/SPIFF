<?php

use Illuminate\Database\Seeder;

class FeaturesProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = \App\Models\Product::all();
        $faker = Faker\Factory::create();
        foreach ($products as $product) {

            for ($i=0 ; $i<5 ; $i++){
                $product->features()->create([
                    'name'          => $faker->name,
                    'description'   => $faker->realText(250)
                ]);
            }

            for ($i=0 ; $i<5 ; $i++){
                $product->thumnbnails()->create([
                    'image'         => $faker->imageUrl(),
                ]);
            }
        }
    }
}
