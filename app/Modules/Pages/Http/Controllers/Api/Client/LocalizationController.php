<?php

namespace App\Modules\Pages\Http\Controllers\Api\Client;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class LocalizationController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLangFile(Request $request)
    {
        if ($request->get('locale')) {
            $locale = $request->get('locale');
        } else {
            $locale = app()->getLocale();
        }

        try {
            $jsonString = file_get_contents(base_path('resources/lang/'.$locale.'.json'));
        } catch (\Exception $ex) {
            $jsonString = file_get_contents(base_path('resources/lang/en.json'));
        }

        $texts = json_decode($jsonString,true);

        return response()->json([
            'data'  => [
                'text'  => $texts
            ]
        ]);
    }

}
