<?php


namespace App\Modules\Pages\Services\Admin;


use App\Modules\Pages\Models\Service;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Service entity
 * @property array infoData
 */
class ServiceStoreData extends BaseStoreData
{


    /**
     * @param null $entityId
     *
     * @return mixed|void
     */
    public function setEntityById($entityId = null)
    {
        $this->entity = Service::find($entityId);
        return $this;
    }

    /**
     * @param array $saveData
     *
     * @return Model|Service
     */
    protected function createEntityData($saveData = [])
    {
        return Service::create($saveData);
    }
}
