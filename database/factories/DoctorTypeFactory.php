<?php

namespace Database\Factories;

use App\Modules\Company\Models\CompanyActivity;
use App\Modules\Customer\Models\DoctorType;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DoctorType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => DoctorType::STATUS_ACTIVE
        ];
    }
}
