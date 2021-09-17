<?php

namespace Database\Factories;

use App\Modules\Company\Models\CompanyActivity;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyActivityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompanyActivity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => CompanyActivity::STATUS_ACTIVE
        ];
    }
}
