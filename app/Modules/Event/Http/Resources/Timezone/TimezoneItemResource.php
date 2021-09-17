<?php
/**
 *  app/Modules/Event/Http/Resources/Timezone/TimezoneItemResource.php
 *
 * Date-Time: 16.07.21
 * Time: 10:12
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Event\Http\Resources\Timezone;


use App\Modules\Customer\Models\Lecturer;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class TimezoneItemResource
 * @package App\Modules\Event\Http\Resources\Timezone
 */
class TimezoneItemResource implements Arrayable
{
    /**
     * @var string
     */
    protected string $timezone;

    /**
     * LecturerItemResource constructor.
     * @param Lecturer $lecturer
     */
    public function __construct(string $timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'value' => $this->timezone,
            'label' => $this->timezone,
        ];
    }
}
