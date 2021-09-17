<?php


namespace App\Modules\Base\Traits;


trait HasTranslationFields
{

    /**
     * @return mixed
     */
    public function getTranslationLocales()
    {
        return $this->translations->where($this->checkTranslationField,'!=',null)->pluck('locale')->toArray();
    }

}
