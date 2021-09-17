<?php

namespace App\Modules\Pages\Http\Controllers\Api\Client;

use App\Modules\Pages\Http\Requests\Client\PageTypeRequest;
use App\Modules\Pages\Http\Requests\Client\PageIndexRequest;
use App\Modules\Pages\Http\Resources\Client\PageMetaInfoResource;
use App\Modules\Pages\Models\Page;

use App\Http\Controllers\Controller;
use Laravel\Jetstream\Jetstream;
use PageSeoService;

class PageController extends Controller
{
    /**
     * @param PageIndexRequest $request
     * @param $module
     *
     * @return \Inertia\Response
     */
    public function index(PageIndexRequest $request, $module)
    {
        $pages = Page::whereIn('name', [$module])->get();
        $items = [];

        foreach($pages as $key => $page) {
            $items[str_replace('-','_',$page->name)] = (new PageMetaInfoResource($page->meta))->toArray($request);
        }
        $pageData = PageSeoService::setPageType($request->get('page'))->getPageData();

        $responseData = [
            'items'         => $items,
            'page_data'     => $pageData
        ];

        return Jetstream::inertia()->render($request, 'Landing/StaticPage',[
            'data'  => $responseData
        ]);
    }

    /**
     * @param PageTypeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pageType(PageTypeRequest $request)
    {
        $seoData = PageSeoService::setPath($request->get('path'))->parsePathAndSetPageType()
                    ->parsePathAndSetLocale()->getPageData();

        return response()->json($seoData);
    }

}
