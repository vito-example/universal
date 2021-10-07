<?php


namespace App\Modules\Pages\Services\Admin;


use App\Modules\Base\Models\Image;
use App\Modules\Pages\Models\Blog;
use Arr;

/**
 * @property Blog entity
 * @property array infoData
 */
abstract class BaseStoreData
{

    /**
     * @var
     */
    protected $entity;

    /**
     * @var
     */
    protected $infoData;

    protected $galleriesData;

    /**
     * @param null $entityId
     *
     * @return mixed
     */
    public abstract function setEntityById($entityId = null);

    /**
     * @param array $saveData
     *
     * @return mixed|Blog
     */
    protected abstract function createEntityData(array $saveData = []);

    /**
     * @return Blog
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param array $infoData
     *
     * @return $this
     */
    public function setInfoData(array $infoData = [])
    {
        $this->infoData = $infoData;
        return $this;
    }

    /**
     * @param array $seoData
     * @return $this
     */
    public function setSeoData(array $seoData = []): BaseStoreData
    {
        foreach ($seoData as $key => $data) {
            if (count($data)) {
                $this->infoData[$key]['seo_meta'] = $data;
            }
        }
        return $this;
    }

    /**
     * @param array $galleriesData
     * @return $this
     */
    public function setGalleriesData(array $galleriesData = []): BaseStoreData
    {
        $this->galleriesData = $galleriesData;
        return $this;
    }

    /**
     * @return $this
     */
    public function store()
    {
        $this->create();
        $this->saveRelationData();
        $this->saveGalleries();
        return $this;
    }

    /**
     * @return void
     */
    private function saveGalleries(): void
    {
        $this->entity->update([
            'galleries_meta' => $this->galleriesData
        ]);
    }

    /**
     * @return $this
     */
    public function saveImages()
    {
        if (empty($this->infoData['images'])) {
            return $this;
        }
        $images = !empty($this->infoData['images']) ? $this->infoData['images'] : [];
        $itemImages = $this->entity->images;

        foreach ($images as $key => $image) {
            $imageModel = Image::findOrFail($image['item']['id']);
            $imageModel->imageable()->associate($this->entity);
            $imageModel->save();
            $itemImages = $itemImages->reject(function ($img) use ($imageModel) {
                return $img->id === $imageModel->id;
            });
        }

        $itemImages->map(function ($modelImage) {
            $modelImage->delete();
        });
        return $this;
    }

    /**
     * @return void
     */
    protected function create()
    {
        $saveData = Arr::except($this->infoData, ['images']);
        if (isset($saveData['date']) && $saveData['date'] === 'Invalid date') {
            $saveData['date'] = null;
        }
        if ($this->entity) {
            $this->entity->update($saveData);
            foreach (config('language_manager.locales') as $locale) {
                $this->entity->translations()->updateOrCreate([
                    convertCamelCaseToSnakeCase(getModelName($this->entity) . '_id') => $this->entity->id,
                    'locale' => $locale
                ], $this->infoData[$locale]);
            }
        } else {
            $this->entity = $this->createEntityData($saveData);
        }
    }

    protected function saveRelationData()
    {
        //
    }

}
