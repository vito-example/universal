<?php


namespace App\Modules\Base\Http\Resources\Admin\Config;


use App\Modules\Base\Models\Config;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSchema\Exception\RuntimeException;

class ConfigResource extends JsonResource
{

    /**
     * ConfigResource constructor.
     *
     * @param null $resource
     * @param array|null $attributeKeys
     */
    public function __construct($resource = null)
    {
        parent::__construct($resource);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|null
     */
    public function toArray($request)
    {
        /** @var $config Config */
        $config = Config::where('key', $this->resource)->first();

        return $config && $config->value_meta ? $config->getValueMeta() : [];
    }

}
