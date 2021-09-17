<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\Customer\Models\Activity;
use App\Modules\Customer\Models\Citizenship;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->lastName,
            'password' => bcrypt('admin123'),
            'surname' => $this->faker->firstName,
            'activity_verify_id'    => $this->faker->uuid,
            'personal_number' => $this->faker->unique(false,1000)->bankAccountNumber,
            'passport_number' => $this->faker->unique(false,1000)->bankAccountNumber,
            'phone_number' => $this->faker->unique(false,1000)->phoneNumber,
            'terms' => 1,
            'advertisement' => $this->faker->randomElement([0,1]),
            'activity_id' => Activity::where('status',Activity::STATUS_ACTIVE)->inRandomOrder()->first()->id,
            'citizenship_id' => Citizenship::where('status',Activity::STATUS_ACTIVE)->inRandomOrder()->first()->id,
            'profile_photo_path' => 'https://pixabay.com/get/gec35accb0857ae88edb68d62e32e2171cfbc52547bbe20f803e4364c2c74e43accb491b6c68a031ce9ee3e7043bee5cd_1280.jpg'
        ];
    }
}
