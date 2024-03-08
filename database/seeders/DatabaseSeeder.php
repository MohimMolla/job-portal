<?php

namespace Database\Seeders;

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
    // \App\Models\User::factory(10)->create();
    $this->call([
        UserSeeder::class,
        LaratrustSeeder::class,
        RoleUserSeeder::class,
        CategorySeeder::class,
        StateCitySeeder::class,
        QualificationSeeder::class,
        SkillSeeder::class,
        ProfileSeeder::class,
    ]);
  }
}
