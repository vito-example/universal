<?php


namespace App\Modules\Pages\Http\Resources\Admin\Page;


use Illuminate\Http\Resources\Json\JsonResource;

class BaseModulesResource extends JsonResource
{
    /**
     * BaseStoryModulesResource constructor.
     *
     * @param null $resource
     */
    public function __construct($resource = null)
    {
        parent::__construct($resource);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $storyModules = [];

        foreach(config('pages.modules.' . $this->resource) as $key => $module) {
            $module['activeLocaleKey'] = config('language_manager.default_locale');
            $module['label'] = __('admin.story.modules_' . $module['key']);
            $moduleInputs = [];
            foreach($module['inputs'] as $input) {
                $input['label'] = __('admin.story.modules_' . $module['key'] . '_' . $input['name']);
                if ($input['is_translation']) {
                    foreach(config('language_manager.locales') as $locale) {
                        $input['locales'][$locale] = '';
                    }
                } if (!empty($input['additional_fields'])) {

                    foreach($input['additional_fields'] as $additionalFieldKey => $additionalFields) {
                        $input['additional_fields'][$additionalFieldKey]['label'] = __('admin.story.modules_' . $module['key'] . '_' . $input['name'] . '_' . $additionalFields['name']);
                        foreach(config('language_manager.locales') as $locale) {
                            $input['additional_fields'][$additionalFieldKey]['locales'][$locale] = '';
                        }
                    }
                } else {
                    $input['value'] = '';
                }
                $moduleInputs[] = $input;
            }
            $module['inputs'] = $moduleInputs;
            $storyModules[] = $module;
        }

        return $storyModules;
    }


}
