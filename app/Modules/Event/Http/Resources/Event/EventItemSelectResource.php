<?php
/**
 *  app/Modules/Event/Http/Resources/Event/EventItemSelectResource.php
 *
 * Date-Time: 26.07.21
 * Time: 11:35
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Event\Http\Resources\Event;


use App\Modules\Event\Models\Event;

/**
 * Class EventItemSelectResource
 * @package App\Modules\Event\Http\Resources\Event
 */
class EventItemSelectResource
{
    /**
     * @var \App\Modules\Event\Models\Event
     */
    protected Event $resource;

    /**
     * EventItemSelectResource constructor.
     *
     * @param \App\Modules\Event\Models\Event $lecturer
     */
    public function __construct(Event $lecturer)
    {
        $this->resource = $lecturer;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'value' => $this->resource->id,
            'label' => $this->resource->title .  " ({$this->resource->id})",
        ];
    }
}