<?php


namespace App\Modules\Base\Http\Resources\Admin\Tag;


use Illuminate\Http\Resources\Json\JsonResource;

class CreateTagResource extends JsonResource
{

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

}
