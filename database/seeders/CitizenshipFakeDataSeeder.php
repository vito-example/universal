<?php

namespace Database\Seeders;

use App\Modules\Customer\Models\Activity;
use App\Modules\Customer\Models\Citizenship;
use Illuminate\Database\Seeder;

class CitizenshipFakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        Citizenship::factory(20)->create()->each(function(Citizenship $item) use($faker){
            $transData = [];
            $countryName = $faker->country;
            foreach(config('language_manager.locales') as $locale) {
                $transData[$locale] = [
                    'title' => $countryName
                ];
            }
            $item->update($transData);
        });
    }
}
