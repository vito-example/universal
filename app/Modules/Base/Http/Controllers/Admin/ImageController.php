<?php

namespace App\Modules\Base\Http\Controllers\Admin;

use App\Models\User;
use App\Modules\Admin\Http\Controllers\BaseController;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use UploadImage;

class ImageController extends BaseController
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        $image = UploadImage::setFile($request->file('file'))->setType($request->get('type'))
            ->initImage()->uploadImage()->saveSrc()->getImage();

        return response()->json([
            'message'   => __('Image Upload Successfully'),
            'item'  => $image
        ]);
    }

}
