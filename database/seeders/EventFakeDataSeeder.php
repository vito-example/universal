<?php

namespace Database\Seeders;

use App\Modules\Customer\Models\Citizenship;
use App\Modules\Event\Http\Resources\Event\EventStatusOptions;
use App\Modules\Event\Models\Event;
use Illuminate\Database\Seeder;

class EventFakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        Event::factory(100)->create()->each(function(Event $item) use($faker){
            $transData = [];
            foreach(config('language_manager.locales') as $locale) {
                $transData[$locale] = [
                    'title' => $faker->name,
                    'description'   => $faker->sentence(50)
                ];
            }
            $item->update($transData);
            $item->forceFill([
                'status'    => $faker->randomElement(EventStatusOptions::getStatuses()->toArray())
            ])->save();
        });
    }
}
