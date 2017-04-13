<?php

use Illuminate\Database\Seeder;

class TargetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $designs = \App\Models\Design::all();

        foreach ($designs as $design) {
            $target = \App\Models\Target::create([
                'targetId' => $faker->creditCardNumber(),
            ]);

            $design->target_id = $target->id;
            $design->save();

            for ($i=0 ; $i<6 ; $i++){
                \App\Models\Resource::create([
                    'resource' =>($i%2 == 0)?asset('dummy/SampleVideo_1280x720_1mb.mp4'):$faker->imageUrl(),
                    'type' => ($i%2 == 0)?'video':'image',
                    'target_id' => $target->id
                ]);
            }
        }
        
    }
}
