<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Admin::factory(2)->create();

        // \App\Models\User::factory(5)->create();

        // Category::factory(5)->create();
        // Product::factory(20)->create();

        $this->call([
            //CategoriesTableSeeder::class,
            //UsersTableSeeder::class,
        ]);
    }
}
