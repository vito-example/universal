<?php

namespace App\Modules\Pages\Http\Controllers\Api\Client;

use App\Modules\Pages\Http\Requests\Client\GetStaticPageRequest;
use App\Modules\Pages\Http\Requests\Client\StaticPageInfoRequest;
use App\Modules\Pages\Models\StaticPage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class StaticPageController extends Controller
{

    /**
     * @param GetStaticPageRequest $request
     * @param $module
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GetStaticPageRequest $request, $module)
    {
        $queryParams = $request->all();
        $staticPages = StaticPage::with(['translations','module','attributeValues.translations'])->where('status',true)->whereHas('module',function(Builder $builder) use($queryParams,$module){
            $builder->where('key', $module);
        })->orderBy('id','desc')
            ->paginate(!empty($queryParams['per_page']) ? $queryParams['per_page'] : 25, '*','page',!empty($queryParams['page']) ? $queryParams['page'] : 1);

        return response()->json([
            'data'  => [
                'items' => $staticPages
            ]
        ]);
    }

    /**
     * @param StaticPageInfoRequest $request
     * @param $module
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(StaticPageInfoRequest $request, $module, $id)
    {
        $staticPage = StaticPage::with(['translations','module','attributeValues.translations'])->where('status',true)->whereHas('module',function(Builder $builder) use($queryParams,$module){
            $builder->where('key', $module);
        })->where('id', $id)->first();

        return response()->json([
            'data'  => [
                'item' => $staticPage
            ]
        ]);
    }

}
