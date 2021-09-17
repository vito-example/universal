<?php


namespace App\Modules\Pages\Services\Admin;


use App\Modules\Base\Models\Image;
use App\Modules\Pages\Models\Blog;
use Arr;

/**
 * @property Blog entity
 * @property array infoData
 */
class BlogStoreData extends BaseStoreData
{


    /**
     * @param null $entityId
     *
     * @return mixed|void
     */
    public function setEntityById($entityId = null)
    {
        $this->entity = Blog::find($entityId);
        return $this;
    }

    /**
     * @param array $saveData
     *
     * @return Blog
     */
    protected function createEntityData($saveData = [])
    {
        return Blog::create($saveData);
    }
}
