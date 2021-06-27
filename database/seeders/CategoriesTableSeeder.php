<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ORM: Eloquent Model
        Category::create([
            'name' => 'Category Model',
            'slug' => 'cateogry-model',
            'status' => 'draft',
        ]);

        // Query Builder
        for ($i = 1; $i <= 10; $i++) {
            DB::table('categories')->insert([
                'name' => 'Category ' . $i,
                'slug' => 'cateogry-' . $i,
                'status' => 'active',
            ]);
        }

        // SQL commands
        // INSERT INTO categories (name, slug, status) 
        // VALUES ('My First Category', 'my-first-category', 'active')
        DB::statement("INSERT INTO categories (name, slug, status) 
        VALUES ('My First Category', 'my-first-category', 'active')");

    }
}
