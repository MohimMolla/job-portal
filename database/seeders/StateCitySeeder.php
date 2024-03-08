<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class StateCitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('Importing City database...');
    $country = Country::create(['name' => 'India']);
    $cities = config('city');
    foreach ($cities as $key => $city_row) {
      if ($key % 100 == 0) {
        $this->command->info('Total Cities: ' . count($cities) . ' / Imported ' . ($key + 1));
      }

      $city = $city_row['city_name'];
      $state = $city_row['city_state'];
      $stateobj = State::where('name', '=', $state)->first();
      if (empty($stateobj)) {
        $stateobj = State::create([
            'name' => $state,
            'country_id' => $country->id,
        ]);
      }
      $cityobj = City::where('name', $city)->where('state_id', $stateobj->id)->first();
      if(empty($cityobj)) {
        City::create(['name' => $city, 'country_id' => $country->id, 'state_id' => $stateobj->id]);
      }
    }

    $this->command->info('Total Cities: ' . count($cities) . ' / Imported ' . ($key + 1));
  }
}
