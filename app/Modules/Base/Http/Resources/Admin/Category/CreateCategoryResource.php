<?php


namespace App\Modules\Base\Http\Resources\Admin\Category;


use App\Modules\Base\Models\Translations\CategoryTranslation;
use App\Modules\Pages\Models\Translations\StaticPageTranslation;
use Illuminate\Http\Resources\Json\JsonResource;
use TranslationFieldsWithLocale;

class CreateCategoryResource extends JsonResource
{

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $locales = TranslationFieldsWithLocale::setTranslations($this->resource->translations)->setTranslationFields((new CategoryTranslation())->getFillable())
            ->generateFieldsWithLocales()->getFieldsWithLocales();

        $category = $locales;
        $category = array_merge($category, $this->resource->only($this->resource->getFillable()));

        return [
            'main'  => $category
        ];
    }

}
