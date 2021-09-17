<?php
/**
 *  app\Modules\Event\Http\Resources\Session\EventSessionTypeOptions.php
 *
 * Date-Time: 7/25/2021
 * Time: 6:43 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Event\Http\Resources\Session;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Collection;
use ReflectionClass;
use Str;

/**
 *  app\Modules\Event\Http\Resources\Session\EventSessionTypeOptions.php
 *
 * Date-Time: 7/25/2021
 * Time: 6:43 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
class EventSessionTypeOptions
{
    /**
     * EventSession type list.
     */
    public const SESSION_TYPE_PLANNED = 100;
    public const SESSION_TYPE_REQUEST = 200;

    /**
     * @return array|void
     */
    public function toArray()
    {
        return self::getTypes()->map(function ($type, $label) {
            return [
                'label' => __('admin.training_session.' . Str::lower($label)),
                'value' => $type
            ];
        })->toArray();
    }

    /**
     * @param int $type
     *
     * @return array|Application|Translator|string|null
     */
    public function getTypesLabelById(int $type = self::SESSION_TYPE_PLANNED)
    {
        $type = collect(self::getTypes()->filter(function ($statusId) use ($type) {
            return $statusId === $type;
        }));

        if ($type === null) {
            return '';
        }

        return __('admin.training_session.' . Str::lower($type->keys()->first()));
    }

    /**
     * @return Collection
     */
    public static function getTypes(): Collection
    {
        return collect((new ReflectionClass(__CLASS__))->getConstants())
            ->filter(function ($value, $key) {
                return Str::contains($key, 'TYPE_');
            });
    }

    /**
     * @return int[]
     */
    public static function getFrontDenyTypes(): array
    {
        return [
            self::SESSION_TYPE_PLANNED,
            self::SESSION_TYPE_REQUEST
        ];
    }

}
