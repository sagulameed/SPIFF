<?php

use Illuminate\Database\Seeder;
use App\Models\Category;
class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['fashion','cartoon','metal','wood','plastic','old fashion','clear'];

        foreach ($categories as $category) {
            Category::create([
                'name'=>$category,
                'description' => "This is a description of $category"
            ]);
        }
    }
}
