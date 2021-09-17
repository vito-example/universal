<?php


namespace App\Modules\Pages\Http\Resources\Client;


use App\Modules\Base\Models\Image;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class PageMetaInfoResource extends JsonResource
{

    /**
     * PageMetaInfoResource constructor.
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
    public function toArray($request = null)
    {
        /** @var Collection $meta */
        $metaData = collect($this->resource);
        $metaModules = [];;

        foreach($metaData as $key => $meta) {
            if (array_key_exists('status', $meta) && empty($meta['status'])) {
                continue;
            }
            $metaInputs = [];
            foreach((array)$meta['inputs'] as $input) {
                if(!is_array($input)) {
                    continue;
                }
                $inputName = $input['name'];
                $metaInputs[$inputName] = [
                    'name'      => $inputName,
                    'type'      => $input['type'],
                    'label'     => $input['label'],
                ];

                $value = null;
                if (!empty($input['locales'])) {
                    $value = !empty($input['locales'][app()->getLocale()]) ? $input['locales'][app()->getLocale()] : '';
                 } else if (!empty($input['images'])) {
                    $images = [];
                    foreach($input['images'] as $image) {
                        $imageFields = [];

                        if (!empty($image['additional_fields'])) {
                            foreach($image['additional_fields'] as $additionalField) {
                                $value = null;
                                if (!empty($additionalField['locales'])) {
                                    $value = !empty($additionalField['locales'][app()->getLocale()]) ? $additionalField['locales'][app()->getLocale()] : '';
                                }
                                if (!empty($additionalField['value'])) {
                                    $value = $additionalField['value'];
                                }
                                if (!empty($additionalField['image'])) {
                                    $img = Image::find($additionalField['image']['id']);
                                    $value = $img ? $img->full_src : '';
                                }

                                $imageFields[] = [
                                    'name'      => $additionalField['name'],
                                    'type'      => $additionalField['type'],
                                    'label'     => $additionalField['label'],
                                    'value'     => $value
                                ];
                            }
                        }

                        $image = Image::findOrFail($image['image_id']);
                        $images[] = [
                            'full_src'   => $image->full_src,
                            'fields'     => $imageFields
                        ];
                    }
                    $value = $images;
                } else if (!empty($input['image'])) {
                    $value = Image::findOrFail($input['image']['id'])->full_src;
                } else if (!empty($input['coordinates'])) {
                    $value = $input['coordinates'];
                }  else if (!empty($input['value'])) {
                    $value = $input['value'];
                }  else if (!empty($input['fields'])) {
                    $inputFields = [];
                    foreach($input['fields'] as $fieldKey => $allInputField) {
                        foreach($allInputField as $inputField) {
                            $value = '';
                            if (!empty($inputField['locales'])) {
                                $value = !empty($inputField['locales'][app()->getLocale()]) ? $inputField['locales'][app()->getLocale()] : '';
                            }
                            if (empty($value) && !empty($inputField['value'])) {
                                $value = $inputField['value'];
                            }
                            if (empty($value) && !isset($inputField['value']) && isset($inputField['file'])) {
                                $value = $inputField['file']['full_src'];
                            }

                            if (!is_array($inputField)) {
                                continue;
                            }
                            $inputFields[$fieldKey][] = [
                                'name'      => $inputField['name'],
                                'type'      => $inputField['type'],
                                'label'     => $inputField['label'],
                                'value'     => $value
                            ];
                        }
                    }
                    $value = $inputFields;
                }

                $metaInputs[$inputName]['value'] = $value;
            }

            $metaModules[] = [
                'key'       => str_replace('-','_', $meta['key']),
                'options'   => !empty($meta['options']) ? $meta['options'] : [],
                'fields'    => $metaInputs
            ];
        }

        return $metaModules;
    }

}
