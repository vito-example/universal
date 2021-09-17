<?php

namespace App\Modules\Pages\Http\Controllers\Admin;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Pages\Helpers\PageHelper;
use App\Modules\Pages\Helpers\StaticPageHelper;
use App\Modules\Pages\Http\Resources\Admin\Page\BaseModulesResource;
use App\Modules\Pages\Http\Resources\Admin\Page\PageResource;
use App\Modules\Pages\Models\Page;
use App\Utilities\ServiceResponse;
use Arr;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Log;
use PageStore;

class PageController extends BaseController
{
    protected string $baseModuleName = 'pages::';

    /**
     * @var string
     */
    public $moduleTitle = 'page';

    /**
     * @var string
     */
    public $viewFolderName = 'page';

    /**
     * StaticPageController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'page';
        $this->baseData['baseRouteName'] = $this->baseData['baseRouteName'] . '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = PageHelper::getLang('page');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createData(Request $request)
    {
        try {
            $this->baseData['routes'] = PageHelper::getRoutes('page');
            $this->baseData['routes']['upload_image'] = route(config('cms.admin.base_route_name') .'.image.upload');
            $page = null;
            if ($request->get('type')) {
                $page = Page::where('name', $request->get('type'))->first();
                if ($page && $page->meta) {
                    $this->baseData['item']['meta'] = (new PageResource($request->get('type'),$page))->toArray($request);
                }
            }
            $this->baseData['options']['grids'] = config('pages.options.grids');
            $this->baseData['options']['all_modules'] = (new BaseModulesResource($request->get('type')))->toArray($request);
        } catch (\Exception $ex) {
            Log::error('Error during blog create page', ['message' => $ex->getMessage(), 'data' => $request->all()]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification(__('Filter role successfully'), 200,  $this->baseData );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            PageStore::setBaseData($request->all())->setName($request->get('type',''))->save();

        } catch (\Exception $ex) {
            Log::error('Error page save',[
                'error' => $ex
            ]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200,  $this->baseData );
    }

    /**
     * @param string $type
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($type = '')
    {
        try {
            $this->baseData['routes']['create_form_data'] = PageHelper::getRoutes('page')['create_data'];
            $this->baseData['routes']['upload_image'] = route(config('cms.admin.base_route_name') .'.image.upload');
            $this->baseData['type'] = $type;
        } catch (\Exception $ex) {
            return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::error($ex->getMessage()));
        }

        return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::success($this->baseData));
    }


}
