<?php


namespace App\Modules\Pages\Services\Admin;


use App\Modules\Pages\Models\Project;
use Arr;

/**
 * @property Project entity
 * @property array infoData
 */
class ProjectStoreData extends BaseStoreData
{


    /**
     * @param null $entityId
     *
     * @return mixed|void
     */
    public function setEntityById($entityId = null)
    {
        $this->entity = Project::find($entityId);
        return $this;
    }

    /**
     * @param array $saveData
     *
     * @return Project
     */
    protected function createEntityData($saveData = [])
    {
        return Project::create($saveData);
    }
}
