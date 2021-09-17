<?php

namespace Database\Seeders;

use App\Modules\Base\Models\Image;
use App\Modules\Customer\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitiesFakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        Activity::factory(20)->create()->each(function(Activity $activity) use($faker){
            $transData = [];
            foreach(config('language_manager.locales') as $locale) {
                $transData[$locale] = [
                    'title' => $faker->jobTitle
                ];
            }
            $activity->update($transData);
        });
    }

}
