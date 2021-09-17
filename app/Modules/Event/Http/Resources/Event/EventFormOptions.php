<?php
/**
 *  app/Modules/Event/Http/Resources/Event/EventFormOptions.php
 *
 * Date-Time: 15.07.21
 * Time: 13:04
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Event\Http\Resources\Event;


use Illuminate\Support\Collection;
use ReflectionClass;
use Str;

/**
 * Class EventFormOptions
 * @package App\Modules\Event\Http\Resources\Event
 */
class EventFormOptions
{
    /**
     * Event type list.
     */
    public const FORM_OFFLINE = 100;
    public const FORM_ONLINE = 200;

    /**
     * @return array|void
     */
    public function toArray()
    {
        return self::getTypes()->map(function($form,$label){
            return [
                'label' => __('admin.event.' . Str::lower($label)),
                'value'     => $form
            ];
        })->toArray();
    }

    /**
     * @param int $type
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getTypesLabelById(int $type = self::FORM_OFFLINE)
    {
        $type = collect(self::getTypes()->filter(function($statusId)use($type){
            return $statusId === $type;
        }));

        if($type === null) {
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
                return Str::contains($key, 'FORM_');
            });
    }

    /**
     * @return int[]
     */
    public static function getFrontDenyTypes(): array
    {
        return [
            self::FORM_OFFLINE,
            self::FORM_OFFLINE
        ];
    }

}
