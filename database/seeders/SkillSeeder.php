<?php

namespace Database\Seeders;

use App\Models\Skill;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('Importing skill database...');
    $skills = config('skills');

    foreach ($skills as $key => $skill) {
      if ($key % 20 == 0) {
        $this->command->info('Total skills: ' . count($skills) . ' / Imported ' . ($key + 1));
      }

      $name = $skill['name'];
      $description = $skill['description'];
      $created_at = Carbon::now()->toDateTimeString();
      $updated_at = Carbon::now()->toDateTimeString();
      $skillobj = Skill::where('name', $name)->first();
      if (empty($skillobj)) {
        Skill::create([
          'name' => $name,
          'description' => $description,
          'created_at' => $created_at,
          'updated_at' => $updated_at
        ]);
      }
    }

    $this->command->info('Total Cities: ' . count($skills) . ' / Imported ' . ($key + 1));
  }
}
