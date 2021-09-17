<?php


namespace App\Modules\Event\Http\Resources\Event;


use Illuminate\Contracts\Support\Arrayable;
use ReflectionClass;
use Str;

class EventCreditPointTypesResource implements Arrayable
{

    /**
     * Event credit point types
     */
    const EVENT_CREDIT_POINT_TYPE_MEMBER = 'member';
    const EVENT_CREDIT_POINT_TYPE_SPEAKER = 'speaker';

    /**
     * @return array|void
     */
    public function toArray()
    {
        return self::getAllPriceOptions()->map(function($eventPrice){
            return [
                'label'     => __('admin.event.event_credit_point_type_' . $eventPrice),
                'value'     => $eventPrice
            ];
        })->toArray();
    }

    /**
     * @param $priceOptionValue
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getPriceOptionByValue($priceOptionValue)
    {
        return __('admin.event.event_credit_point_type_' . $priceOptionValue);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getAllPriceOptions()
    {
        return collect((new ReflectionClass(__CLASS__))->getConstants())
            ->filter(function ($value, $key) {
                return Str::contains($key, 'EVENT_CREDIT_POINT_TYPE_');
            });
    }

}
