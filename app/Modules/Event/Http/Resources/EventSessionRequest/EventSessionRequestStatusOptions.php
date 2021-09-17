<?php
/**
 *  app/Modules/Event/Http/Resources/EventSessionRequest/EventSessionRequestStatusOptions.php
 *
 * Date-Time: 28.07.21
 * Time: 11:18
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Event\Http\Resources\EventSessionRequest;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Collection;
use ReflectionClass;
use Str;

/**
 * Class EventSessionRequestStatusOptions
 * @package App\Modules\Event\Http\Resources\EventSessionRequest
 */
class EventSessionRequestStatusOptions
{
    /**
     * EventSessionRequest status list.
     */
    const STATUS_PENDING = 100;
    const STATUS_SUCCESS = 200;
    const STATUS_DENIED = 300;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return self::getStatuses()->map(function($status,$label){
            return [
                'label' => __('admin.session_request.' . Str::lower($label)),
                'value'     => $status
            ];
        })->toArray();
    }

    /**
     * @param int|null $status
     *
     * @return array|Application|Translator|string|null
     */
    public function getStatusLabelById(?int $status = self::STATUS_PENDING)
    {
        $status = collect(self::getStatuses()->filter(function($statusId)use($status){
            return $statusId === $status;
        }));

        if($status === null) {
            return '';
        }

        return __('admin.session_request.' . Str::lower($status->keys()->first()));
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
            self::STATUS_SUCCESS
        ];
    }

}
