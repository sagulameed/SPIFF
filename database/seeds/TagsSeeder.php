<?php

use Illuminate\Database\Seeder;
use App\Models\Tag;
class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['trending','viral','new','pack old','newest','byMySelf','php'];

        foreach ($tags as $tag) {
            Tag::create([
                'name'=>$tag,
                'description' => "This is a description of $tag"
            ]);
        }
    }
}
