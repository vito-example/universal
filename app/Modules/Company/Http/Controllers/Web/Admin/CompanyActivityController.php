<?php

namespace App\Modules\Company\Http\Controllers\Web\Admin;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Company\Helpers\CompanyActivityHelper;
use App\Modules\Company\Http\Requests\Admin\CompanyActivityStoreRequest;
use App\Modules\Company\Http\Resources\Company\CompanyItemResource;
use App\Modules\Company\Http\Resources\CompanyActivity\CompanyActivityItemResource;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyActivity;
use App\Modules\Company\Models\Translations\CompanyActivityTranslation;
use App\Utilities\ServiceResponse;
use Arr;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Log;
use TranslationFieldsWithLocale;

class CompanyActivityController extends BaseController
{

    protected string $baseModuleName = 'company::';

    /**
     * @var string
     */
    public $moduleTitle = 'company_activity';

    /**
     * @var string
     */
    public $viewFolderName = 'company_activity';

    /**
     * AuthorController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'company_activity';
        $this->baseData['baseRouteName'] = $this->baseData['baseRouteName'] . '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = CompanyActivityHelper::getLang();
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->baseData['allData'] = CompanyActivity::orderBy('created_at','desc')->paginate(25);

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName.'.index', $this->baseData);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        try {
            $this->baseData['routes']['create_form_data'] = CompanyActivityHelper::getRoutes()['create_data'];

        } catch (\Exception $ex) {
            return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.create', ServiceResponse::error($ex->getMessage()));
        }

        return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.create', ServiceResponse::success($this->baseData));
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
            $this->baseData['routes'] = CompanyActivityHelper::getRoutes();
            $this->baseData['routes']['upload_image'] = route(config('cms.admin.base_route_name') .'.image.upload');

            if ($request->get('id')) {
                $item = CompanyActivity::findOrFail($request->get('id'))->load(['translations']);
                $locales = TranslationFieldsWithLocale::setTranslations($item->translations)->setTranslationFields((new CompanyActivityTranslation())->getFillable())
                    ->generateFieldsWithLocales()->getFieldsWithLocales();
                $this->baseData['item']['main'] = $locales;
                $this->baseData['item']['main'] = array_merge($this->baseData['item']['main'], $item->only($item->getFillable()));
            }
        } catch (\Exception $ex) {
            Log::error('Error during roles index page', ['error' => $ex,'message' => $ex->getMessage(), 'data' => $request->all()]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification(__('Filter role successfully'), 200,  $this->baseData );
    }

    /**
     * @param CompanyActivityStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CompanyActivityStoreRequest $request)
    {
        try {
            $saveData = Arr::except($request->except(['id'])['main'], array_merge(['profile'],(new CompanyActivityTranslation())->getFillable()));
            if ($request->get('id')) {
                $item = CompanyActivity::findOrFail($request->get('id'));
                $item->update($saveData);
            } else {
                $item = CompanyActivity::create($saveData);
            }

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200,  $this->baseData );
    }

    /**
     * @param string $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id = '')
    {
        try {
            $this->baseData['routes']['create_form_data'] = CompanyActivityHelper::getRoutes()['create_data'];

            $this->baseData['id'] = $id;
        } catch (\Exception $ex) {
            return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::error($ex->getMessage()));
        }

        return  view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::success($this->baseData));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        try {
            CompanyActivity::findOrFail($request->get('id'))->delete();
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['delete_successfully'], 200,  $this->baseData );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        try {
            CompanyActivity::findOrFail($request->get('id'))->update(['status' => $request->get('status')]);
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['update_status_successfully'], 200,  $this->baseData );
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $customers = CompanyActivity::filter($request->all())->get();

        return response()->json([
            'data'  => [
                'items' => $customers->map(function(CompanyActivity $item){
                    return (new CompanyActivityItemResource($item))->toArray();
                })
            ]
        ]);
    }


}
