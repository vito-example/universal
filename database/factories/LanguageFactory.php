<?php

namespace Database\Factories;

use App\Modules\Event\Models\EventLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status'    => $this->faker->randomElement([0,1])
        ];
    }
}
