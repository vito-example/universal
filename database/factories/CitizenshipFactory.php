<?php

namespace Database\Factories;

use App\Modules\Customer\Models\Citizenship;
use Illuminate\Database\Eloquent\Factories\Factory;

class CitizenshipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Citizenship::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_code'  => $this->faker->countryCode,
            'status'    => $this->faker->randomElement([0,1])
        ];
    }
}
