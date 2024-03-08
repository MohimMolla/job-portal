<?php

namespace Database\Seeders;

use App\Models\Qualification;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('Importing category database...');
    $qualifications = config('qualifications');

    foreach ($qualifications as $key => $category) {
      if ($key % 20 == 0) {
        $this->command->info('Total qualifications: ' . count($qualifications) . ' / Imported ' . ($key + 1));
      }

      $name = $category['name'];
      $qualficationobj = Qualification::where('name', $name)->first();
      if (empty($qualficationobj)) {
        Qualification::create([
          'name' => $name,
        ]);
      }
    }
  }
}
