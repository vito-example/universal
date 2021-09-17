<?php


namespace App\Modules\Event\Http\Resources\Event;


use Illuminate\Contracts\Support\Arrayable;
use ReflectionClass;
use Str;

class EventPriceOptions implements Arrayable
{

    /**
     * Event price options.
     */
    public const EVENT_PRICE_OPTION = 'free';
    public const EVENT_PRICE_PAID_FOR_ALL = 'paid_for_all';

    /**
     * @return array|void
     */
    public function toArray()
    {
        return self::getAllPriceOptions()->map(function($eventPrice){
            return [
                'label'     => __('admin.event.event_price_option_' . $eventPrice),
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
        return __('admin.event.event_price_option_' . $priceOptionValue);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getAllPriceOptions(): \Illuminate\Support\Collection
    {
        return collect((new ReflectionClass(__CLASS__))->getConstants())
            ->filter(function ($value, $key) {
                return Str::contains($key, 'EVENT_PRICE_');
            });
    }

}
