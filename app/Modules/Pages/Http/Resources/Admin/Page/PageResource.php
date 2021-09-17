<?php


namespace App\Modules\Pages\Http\Resources\Admin\Page;


use App\Modules\Pages\Models\Page;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string pageKey
 */
class PageResource extends JsonResource
{

    /**
     * @var
     */
    protected $pageKey;

    /**
     * PageResource constructor.
     *
     * @param $key
     * @param null $resource
     */
    public function __construct($key, $resource = null)
    {
        parent::__construct($resource);
        $this->pageKey = $key;
    }

    public function toArray($request)
    {
        /** @var $story Page */
        $page = $this->resource;
        $pageModules = $page ? $page->meta : null;
        $configModules = config('pages.modules.' . $this->pageKey);
        if ($pageModules) {
            $configModules = $pageModules;
        }
        $id = 0;

        foreach ($configModules as $key => $module) {
            $pageModuleData = $pageModules ? collect($pageModules[$key]) : null;
            $sortWeight = $pageModuleData && !empty($pageModuleData['sort_weight']) ? $pageModuleData['sort_weight'] : $id;

            $configModules[$id] = [
                'id' => !empty($module['id']) ? $module['id'] : $id,
                'sort_weight' => $sortWeight,
                'activeLocaleKey' => config('language_manager.default_locale'),
                'key' => $module['key'],
                'label' => $pageModuleData ? $pageModuleData['label'] : __('admin.page.modules_' . $module['key']),
                'status' => !empty($pageModuleData['status']) ? $pageModuleData['status'] : 0,
                'options' => $pageModuleData && !empty($pageModuleData['options']) ? $pageModuleData['options'] : null
            ];

            $pageModuleInputs = $pageModuleData && !empty($pageModuleData['inputs']) ? collect($pageModuleData['inputs']) : collect();
            $moduleInputs = [];
            foreach ($module['inputs'] as $input) {
                if (!is_array($input)) {
                    continue;
                }
                $moduleInput = $pageModuleInputs->where('name', $input['name'])->first();

                $input['label'] = __('admin.page.modules_' . $module['key'] . '_' . $input['name']);
                if ($input['is_translation']) {
                    foreach (config('language_manager.locales') as $locale) {
                        $input['locales'][$locale] = $moduleInput && !empty($moduleInput['locales'][$locale]) ? $moduleInput['locales'][$locale] : '';
                    }
                }

                if (!empty($input['fields'])) {
                    foreach ($input['fields'] as $additionalFieldKey => $additionalFields) {
                        $input['fields'][$additionalFieldKey]['id'] = uniqid();
                    }
                }

                if (!empty($input['additional_fields'])) {
                    foreach ($input['additional_fields'] as $additionalFieldKey => $additionalFields) {
                        $additionalFieldPageValue = $moduleInput && !empty($moduleInput['additional_fields']) ? collect($moduleInput['additional_fields'])->where('name', $additionalFields['name'])->first() : [];
                        $input['additional_fields'][$additionalFieldKey]['label'] = __('admin.page.modules_' . $module['key'] . '_' . $input['name'] . '_' . $additionalFields['name']);
                        foreach (config('language_manager.locales') as $locale) {
                            $input['additional_fields'][$additionalFieldKey]['locales'][$locale] = $additionalFieldPageValue && !empty($additionalFieldPageValue['locales'][$locale]) ? $additionalFieldPageValue['locales'][$locale] : '';
                        }
                    }
                }

                if (array_key_exists('image', $input)) {
                    $input['image'] = $moduleInput && !empty($moduleInput['image']) ? $moduleInput['image'] : [];
                }

                if (array_key_exists('images', $input)) {
                    $input['images'] = $moduleInput && !empty($moduleInput['images']) ? $moduleInput['images'] : [];
                }

                if (empty($input['additional_fields']) && !$input['is_translation']) {
                    $input['value'] = $moduleInput && !empty($moduleInput['value']) ? $moduleInput['value'] : '';
                }
                $moduleInputs[] = $input;
            }
            $moduleInputs['id'] = uniqid();
            $configModules[$id]['inputs'] = $moduleInputs;
            if (is_string($key)) {
                unset($configModules[$key]);
            }
            $id++;
        }

        return collect($configModules)->sortBy('sort_weight');
    }

}
