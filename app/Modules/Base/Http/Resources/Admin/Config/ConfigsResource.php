<?php


namespace App\Modules\Base\Http\Resources\Admin\Config;


use App\Modules\Base\Models\Config;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSchema\Exception\RuntimeException;

/**
 * @property array attributeKeys
 */
class ConfigsResource extends JsonResource
{

    /**
     * @var array|null
     */
    protected $attributeKeys = [];

    /**
     * ConfigResource constructor.
     *
     * @param null $resource
     * @param array|null $attributeKeys
     */
    public function __construct($resource = null, array $attributeKeys = null)
    {
        parent::__construct($resource);
        $this->attributeKeys = $attributeKeys;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        /** @var $config Config */
        $config = $this->resource;
        $data = [];
        $attributes = collect(config('config_module.attributes'))->whereIn('key',$this->attributeKeys);

        foreach($attributes as $attribute) {
            if ($config && $config->value_meta) {
                $configAttribute = collect($config->value_meta)->where('key', $attribute['key'])->first();
                if ($configAttribute) {
                    $attribute['value'] = $configAttribute['value'];
                }
            }
            $attribute['label'] = __('admin.' . $attribute['label']);
            $options = [];
            if(!empty($attribute['options'])) {
                foreach($attribute['options'] as $option) {
                    $option['label'] = __('admin.' . $option['label']);
                    $options[] = $option;
                }
            }
            $attribute['options'] = $options;
            $data[] = $attribute;
        }

        return $data;
    }

}
