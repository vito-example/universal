<?php


namespace App\Modules\Base\Http\Resources\Admin\Slug;


use Illuminate\Http\Resources\Json\JsonResource;

class CreateSlugResource extends JsonResource
{

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array|mixed
     */
    public function toArray($request)
    {
        $data['main'] = $this->resource->toArray();

        return $data;
    }

}
