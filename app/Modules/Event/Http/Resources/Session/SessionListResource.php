<?php
/**
 *  app\Modules\Event\Http\Resources\Session\SessionListResource.php
 *
 * Date-Time: 7/17/2021
 * Time: 9:34 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Event\Http\Resources\Session;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class SessionListResource
 * @package App\Modules\Event\Http\Resources\Session
 */
class SessionListResource implements Arrayable
{

    /**
     * @var
     */
    protected $sessions;

    /**
     * QuestionListResource constructor.
     *
     * @param $sessions
     */
    public function __construct($sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $sessionsData = [];
        foreach($this->sessions as $session) {
            $questionsData[] = (new SessionItemResource($session))->toArray();
        }

        return $sessionsData;
    }
}
