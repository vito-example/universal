<?php
/**
 *  app/Modules/Event/Http/Resources/Event/EventTypeOptions.php
 *
 * Date-Time: 15.07.21
 * Time: 10:30
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Event\Http\Resources\Event;


use Illuminate\Support\Collection;
use ReflectionClass;
use Str;

/**
 * Class EventTypeOptions
 * @package App\Modules\Event\Http\Resources\Event
 */
class EventTypeOptions
{
    /**
     * Event type list.
     */
    public const TYPE_PLANNED = 100;
    public const TYPE_REQUEST = 200;

    /**
     * @return array|void
     */
    public function toArray()
    {
        return self::getTypes()->map(function ($type, $label) {
            return [
                'label' => __('admin.event.' . Str::lower($label)),
                'value' => $type
            ];
        })->toArray();
    }

    /**
     * @param int $type
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getTypesLabelById(int $type = self::TYPE_PLANNED)
    {
        $type = collect(self::getTypes()->filter(function ($statusId) use ($type) {
            return $statusId === $type;
        }));

        if ($type === null) {
            return '';
        }

        return __('admin.event.' . Str::lower($type->keys()->first()));
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
     * @return array
     */
    public function getFilterTypes()
    {
        $types [] = [
            'label' => __('training.ტრენინგის ტიპი'),
            'value' => ''
        ];
        foreach (self::getTypes() as $key => $item) {
            $types[] = [
                'label' => __('training.' . $key),
                'value' => $item
            ];
        }
        return $types;
    }

    /**
     * @return int[]
     */
    public static function getFrontDenyTypes(): array
    {
        return [
            self::TYPE_PLANNED,
            self::TYPE_REQUEST
        ];
    }

}
