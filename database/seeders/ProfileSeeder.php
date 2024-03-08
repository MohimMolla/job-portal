<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('Importing profile database...');
    $users = User::all(['id']);
    foreach ($users as $key => $user) {
      if ($key % 20 == 0) {
        $this->command->info('Total profiles: ' . count($users) . ' / Imported ' . ($key + 1));
      }
      $id = $user->id;
      $profileobj = Profile::whereUserId($id)->first();
      if (empty($profileobj)) {
        Profile::create([
          'user_id' => $id,
          'created_at' => Carbon::now()->toDateTimeString(),
          'updated_at' => Carbon::now()->toDateTimeString()
        ]);
      }
    }
    $this->command->info('Total Profiles: ' . count($users) . ' / Imported ' . ($key + 1));
  }
}
