<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('Importing category database...');
    $categories = config('categories');

    foreach ($categories as $key => $category) {
      if ($key % 20 == 0) {
        $this->command->info('Total Categories: ' . count($categories) . ' / Imported ' . ($key + 1));
      }

      $name = $category['name'];
      $description = $category['description'];
      $created_at = $category['created_at'];
      $updated_at = $category['updated_at'];
      $categoryobj = Category::where('name', $name)->first();
      if (empty($categoryobj)) {
        Category::create([
            'name' => $name,
            'description' => $description,
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ]);
      }
    }
  }
}
