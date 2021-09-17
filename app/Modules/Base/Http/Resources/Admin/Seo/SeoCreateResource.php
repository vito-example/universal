<?php


namespace App\Modules\Base\Http\Resources\Admin\Seo;


use App\Modules\Pages\Models\Translations\StaticPageTranslation;
use GetImageWithType;
use Illuminate\Http\Resources\Json\JsonResource;
use TranslationFieldsWithLocale;

class SeoCreateResource extends JsonResource
{

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $images = GetImageWithType::setImages($this->resource->images->toArray() ?: [])->generateWithType()->getImagesWithType();
        $locales = TranslationFieldsWithLocale::setTranslations($this->resource->translations)->setTranslationFields((new StaticPageTranslation())->getFillable())
            ->generateFieldsWithLocales()->getFieldsWithLocales();

        $data = $locales;
        $data = array_merge($data, $this->resource->only($this->resource->getFillable()));
        $data['images'] = $images;

        return $data;
    }

}
