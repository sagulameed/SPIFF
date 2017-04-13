<?php

use Illuminate\Database\Seeder;

class AddVideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i=0 ; $i<=10; $i++ ){
            \App\Models\Video::create([
                'title'         => $faker->sentence(3,true),
                'subtitle'      => $faker->sentence(8,true),
                'description'   => $faker->paragraphs(3,true),
                'thumbnail'     => 'http://localhost:8888/spiff/public/uploads/videos/thumbnail_mark-video-i.jpg',
                'video'         => 'http://localhost:8888/spiff/public/uploads/videos/video_mark-video-i.mp4',
                'duration'      => "1:20",
                'numViews'      => $faker->randomDigit,
                'user_id'       => 3
            ]);
        }

    }
}
