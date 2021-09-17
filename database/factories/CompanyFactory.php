<?php

namespace Database\Factories;

use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        return [
            'title' => $faker->company,
            'description' => $faker->sentence(50),
            'identity_id' => $faker->uuid
        ];
    }
}
