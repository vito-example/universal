<?php


namespace App\Modules\Base\Services\Admin\Translations;


use Illuminate\Database\Eloquent\Collection;

/**
 * @property Collection translations
 * @property array fieldsWithLocales
 * @property array fields
 */
class TranslationFieldsWithLocale
{

    /** @var */
    protected $translations;

    /** @var */
    protected $fieldsWithLocales;

    /** @var array */
    protected $fields = [];

    /**
     * @param Collection $translations
     *
     * @return $this
     */
    public function setTranslations(Collection $translations) : self
    {
        $this->translations = $translations;
        return $this;
    }

    /**
     * @param array $fields
     *
     * @return $this
     */
    public function setTranslationFields(array $fields = []) : self
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return $this
     */
    public function generateFieldsWithLocales() : self
    {
        foreach(config('language_manager.locales') as $locale) {
            $translation = $this->translations->where('locale', $locale)->first();
            if (!empty($translation)) {
                foreach($translation->getFillable() as $field) {
                    $this->fieldsWithLocales[$locale][$field] = $translation->{$field};
                }
            } else {
                foreach($this->fields as $field) {
                    $this->fieldsWithLocales[$locale][$field] = null;
                }
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getFieldsWithLocales() : array
    {
        return $this->fieldsWithLocales;
    }

}
