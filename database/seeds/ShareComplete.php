<?php

use Illuminate\Database\Seeder;

class ShareComplete extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $user = \App\Models\User::find(2);
        for ($j =0 ; $j<4 ;$j++){
            $product = \App\Models\Product::create([
                'product_name'=>'Product:'.$faker->firstName,
                'product_image' => $faker->imageUrl(),
                'video'=> asset('dummy/SampleVideo_1280x720_1mb.mp4'),
                'user_id' => $user->id
            ]);
            $design = \App\Models\Design::create([
                'name' =>$faker->userName,
                'product_id' => $product->id,
                'user_id' =>$user->id
            ]);
            $adminDesign = \App\Models\AdminDesign::create([
                'name' => $faker->company,
                'product_id' => $product->id
            ]);

            for ($i =0 ; $i<4 ;$i++){



             $adminLay = new \App\Models\AdminLayout();
                    //$adminLay->layout_name = $faker->firstName;
                    $adminLay->canvas_thumbnail = $faker->imageUrl();
                    $adminLay->canvas_json = 'Canvas url';
                    $adminLay->isTarget = 0;
                    //$adminLay->product_id = $product->id;
                    $adminLay->adminDesign_id = $adminDesign->id;
                    $adminLay->save();



            $layout = \App\Models\Layout::create([
                    'canvas_thumbnail' => $faker->imageUrl(),
                    'canvas_json' => $faker->firstName,
                    'isTarget' => 0,
                    'design_id' => $design->id,
                ]);

            }
           $share = \App\Models\Share::create([
               'status'=>'evaluating',
               'design_id' => $design->id
           ]);

        }
    }
}
