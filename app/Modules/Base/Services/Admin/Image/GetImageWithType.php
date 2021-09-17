<?php


namespace App\Modules\Base\Services\Admin\Image;


/**
 * @property array images
 * @property array imagesWithType
 */
class GetImageWithType
{

    /** @var */
    protected $images;

    /** @var */
    protected $imagesWithType = [];

    /**
     * @param array $images
     *
     * @return $this
     */
    public function setImages(array $images) : self
    {
        $this->images = $images;
        return $this;
    }

    /**
     * @return $this
     */
    public function generateWithType() : self
    {
        foreach($this->images as $image) {
            $this->imagesWithType[$image['type']] = [
                'item'  => $image
            ];
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getImagesWithType() : array
    {
        return $this->imagesWithType;
    }

}
