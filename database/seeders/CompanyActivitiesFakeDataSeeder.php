<?php

namespace Database\Seeders;

use App\Modules\Base\Models\Image;
use App\Modules\Company\Models\CompanyActivity;
use App\Modules\Customer\Models\Activity;
use Illuminate\Database\Seeder;

class CompanyActivitiesFakeDataSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        CompanyActivity::factory(20)->create()->each(function(CompanyActivity $companyActivity) use($faker){
            $transData = [];
            foreach(config('language_manager.locales') as $locale) {
                $transData[$locale] = [
                    'title' => $faker->jobTitle
                ];
            }
            $companyActivity->update($transData);
        });
    }

}
