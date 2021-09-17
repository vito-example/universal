<?php


namespace App\Modules\Event\Http\Resources\Event;


use Illuminate\Support\Collection;
use ReflectionClass;
use Str;

class EventStatusOptions
{
    /**
     * Event status list.
     */
    const STATUS_PENDING_MODERATOR = 100;
    const STATUS_PROCESSING = 200;
    const STATUS_ORGANIZED = 300;
    const STATUS_COMPLETED = 400;
    const STATUS_DECLINED = 500;
    const STATUS_CANCELED = 600;

    /**
     * @return array|void
     */
    public function toArray()
    {
        return $this->getStatuses()->map(function($status,$label){
            return [
                'label' => __('admin.training.' . Str::lower($label)),
                'value'     => $status
            ];
        })->toArray();
    }

    /**
     * @param int $status
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public function getStatusLabelById($status = self::STATUS_PENDING_MODERATOR)
    {
        $status = collect(self::getStatuses()->filter(function($statusId)use($status){
            return $statusId == $status;
        }));

        if(empty($status)) {
            return '';
        }

        return __('admin.training.' . Str::lower($status->keys()->first()));
    }

    /**
     * @return Collection
     */
    public static function getStatuses()
    {
        return collect((new ReflectionClass(__CLASS__))->getConstants())
            ->filter(function ($value, $key) {
                return Str::contains($key, 'STATUS_');
            });
    }

    /**
     * @return int[]
     */
    public static function getFrontDenyStatuses()
    {
        return [
            self::STATUS_PENDING_MODERATOR,
            self::STATUS_PROCESSING,
            self::STATUS_DECLINED,
            self::STATUS_CANCELED
        ];
    }

}
