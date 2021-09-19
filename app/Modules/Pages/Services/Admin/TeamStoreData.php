<?php


namespace App\Modules\Pages\Services\Admin;


use App\Modules\Pages\Models\Project;
use App\Modules\Pages\Models\Team;
use Arr;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Project entity
 * @property array infoData
 */
class TeamStoreData extends BaseStoreData
{


    /**
     * @param null $entityId
     *
     * @return mixed|void
     */
    public function setEntityById($entityId = null)
    {
        $this->entity = Team::find($entityId);
        return $this;
    }

    /**
     * @param array $saveData
     *
     * @return Team|Model
     */
    protected function createEntityData($saveData = [])
    {
        return Team::create($saveData);
    }
}
