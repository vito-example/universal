<?php
/**
 *  database/factories/DirectionFactory.php
 *
 * Date-Time: 06.07.21
 * Time: 16:56
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace Database\Factories;

use App\Modules\Customer\Models\Direction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class DirectionFactory
 * @package Database\Factories
 */
class DirectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Direction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement([0, 1])
        ];
    }
}
