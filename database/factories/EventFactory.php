<?php

namespace Database\Factories;

use App\Modules\Admin\Models\User\Admin;
use App\Modules\Customer\Models\Activity;
use App\Modules\Event\Http\Resources\Event\EventPriceOptions;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Models\EventLanguage;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $members = [];
        $membersQty = 0;
        while($membersQty > 0) {
            foreach(config('event.humans_attributes') as $moduleKey => $humanAttributes) {
                $members[$moduleKey][] = $this->getHumansData($humanAttributes);
            }
            $membersQty--;
        }
        $isAccredited = $this->faker->boolean(70);
        $priceOptionValue = $this->faker->randomElement(EventPriceOptions::getAllPriceOptions()->toArray());
        $activities = Activity::where('status',Activity::STATUS_ACTIVE)->inRandomOrder()->get()->take($this->faker->numberBetween(2,10));
        $eventMeta = [
            'price_option_value'    => $priceOptionValue,
            'url'   => $this->faker->url,
            'iframe'    => '<iframe width="560" height="315" src="https://www.youtube.com/embed/mpZUg8hQV3c" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'is_accredited' => $isAccredited ? 1 : 0,
            'credit_points' => [],
            'price' => $priceOptionValue === EventPriceOptions::EVENT_PRICE_PAID_FOR_ALL ? $this->faker->randomFloat() : null,
            'price_activities'  => $priceOptionValue === EventPriceOptions::EVENT_PRICE_PAID_FOR_SOME_ACTIVITIES ?
                $activities->map(function(Activity $activity){
                    return [
                        'activity_id'   => $activity->id,
                        'price'         => $this->faker->randomFloat()
                    ];})
                : []
        ];

        return [
            'title' => $this->faker->title,
            'start_date' => now()->addDays($this->faker->numberBetween(10,100)),
            'timezone' => $this->faker->randomElement(DateTimeZone::listIdentifiers(DateTimeZone::ALL)),
            'organizers_meta'   => [
                'members'   => !empty($members['organizers']) ? $members['organizers'] : null
            ],
            'sponsors_meta' => [
                'members'   => !empty($members['sponsors']) ? $members['sponsors'] : null
            ],
            'moderator_id' => Admin::inRandomOrder()->first()->id,
            'event_language_id' => EventLanguage::where('status',1)->inRandomOrder()->first()->id,
            'event_meta'    => $eventMeta,
            'speakers_meta' => [
                'members'   => !empty($members['speakers']) ? $members['speakers'] : null
            ],
        ];
    }

    private function getHumansData($attributes)
    {
        $fields = [];
        foreach($attributes as $attribute) {
//            if($attribute)
        }
    }

}
