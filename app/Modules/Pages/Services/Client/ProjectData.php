<?php
/**
 *  app\Modules\Pages\Services\Client\ProjectData.php
 *
 * Date-Time: 9/20/2021
 * Time: 5:54 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Pages\Services\Client;

use App\Modules\Landing\Http\Resources\Project\ProjectItemResource;
use App\Modules\Pages\Models\Project;

class ProjectData
{
    /**
     * @var Project
     */
    protected Project $projects;

    /**
     * ProjectData constructor.
     */
    public function __construct()
    {
        $this->projects = new Project();
    }


    /**
     * @return array
     */
    public function getProjects(): array
    {
        $projects = $this->projects::with(['translations', 'images'])
            ->active()->orderBy('created_at', 'DESC')->take(6)->get();

        $projectsData = [];
        foreach ($projects->getIterator() as $project) {
            $projectsData[] = (new ProjectItemResource($project))->toListItem();
        }
        return $projectsData;
    }
}
