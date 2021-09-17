<?php

/**
 *  app\Modules\Event\Http\Resources\Event\EventSessionStatusOptions.php
 *
 * Date-Time: 7/25/2021
 * Time: 1:09 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Event\Http\Resources\Event;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Collection;
use ReflectionClass;
use Str;

/**
 * Class EventSessionStatusOptions
 * @package App\Modules\Event\Http\Resources\Event
 */
class EventSessionStatusOptions
{
    /**
     * Event status list.
     */
    const STATUS_ACTIVE = 100;
    const STATUS_COMPLETED = 200;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->getStatuses()->map(function($status,$label){
            return [
                'label' => __('admin.event_session.' . Str::lower($label)),
                'value'     => $status
            ];
        })->toArray();
    }

    /**
     * @param int|null $status
     *
     * @return array|Application|Translator|string|null
     */
    public function getStatusLabelById(?int $status = self::STATUS_ACTIVE)
    {
        $status = collect(self::getStatuses()->filter(function($statusId)use($status){
            return $statusId === $status;
        }));

        if(empty($status)) {
            return '';
        }

        return __('admin.event_session.' . Str::lower($status->keys()->first()));
    }

    /**
     * @return Collection
     */
    public static function getStatuses(): Collection
    {
        return collect((new ReflectionClass(__CLASS__))->getConstants())
            ->filter(function ($value, $key) {
                return Str::contains($key, 'STATUS_');
            });
    }

    /**
     * @return int[]
     */
    public static function getFrontDenyStatuses(): array
    {
        return [
            self::STATUS_COMPLETED
        ];
    }

}
