<?php

namespace Database\Seeders;

use App\Modules\Customer\Models\Citizenship;
use App\Modules\Event\Models\EventLanguage;
use Illuminate\Database\Seeder;

class LanguageFakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        EventLanguage::factory(20)->create()->each(function(EventLanguage $item) use($faker){
            $transData = [];
            foreach(config('language_manager.locales') as $locale) {
                $transData[$locale] = [
                    'title' => $faker->word
                ];
            }
            $item->update($transData);
        });
    }
}
