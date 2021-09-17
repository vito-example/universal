<?php


namespace App\Modules\Base\Traits;


trait ImageAble
{

    /**
     * @param string $key
     *
     * @return string
     */
    public function getImageByKey(string $key = ''): string
    {
        $image = $this->images->where('type', $key)->first();
        return $image ? $image->full_src : '';
    }

}
