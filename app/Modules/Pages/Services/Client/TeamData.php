<?php
/**
 *  app\Modules\Pages\Services\Client\TeamData.php
 *
 * Date-Time: 9/20/2021
 * Time: 5:56 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Pages\Services\Client;

use App\Modules\Landing\Http\Resources\Team\TeamItemResource;
use App\Modules\Pages\Models\Team;

class TeamData
{
    /**
     * @var Team
     */
    protected Team $teams;

    /**
     * ProjectData constructor.
     */
    public function __construct()
    {
        $this->teams = new Team();
    }


    /**
     * @return array
     */
    public function getTeams(): array
    {
        $teams = $this->teams::with(['translations', 'images'])
            ->active()->orderBy('created_at', 'DESC')->take(4)->get();

        $teamsData = [];
        foreach ($teams->getIterator() as $team) {
            $teamsData[] = (new TeamItemResource($team))->toListItem();
        }
        return $teamsData;
    }
}
