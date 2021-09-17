<?php
/**
 *  database\factories\LecturerFactory.php
 *
 * Date-Time: 7/8/2021
 * Time: 7:30 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace Database\Factories;

use App\Modules\Customer\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class LecturerFactory
 * @package Database\Factories
 */
class LecturerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lecturer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'status'    => $this->faker->randomElement([0,1])
        ];
    }
}
