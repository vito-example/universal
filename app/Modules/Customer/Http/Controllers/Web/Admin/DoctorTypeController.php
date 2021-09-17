<?php

namespace App\Modules\Customer\Http\Controllers\Web\Admin;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Customer\Helpers\DoctorTypeHelper;
use App\Modules\Customer\Http\Requests\Admin\DoctorTypeStoreRequest;
use App\Modules\Customer\Models\DoctorType;
use App\Modules\Customer\Models\Translations\DoctorTypeTranslation;
use App\Utilities\ServiceResponse;
use Arr;
use Illuminate\Http\Request;

use Log;
use TranslationFieldsWithLocale;

class DoctorTypeController extends BaseController
{

    protected string $baseModuleName = 'customer::';

    /**
     * @var string
     */
    public $moduleTitle = 'doctor_type';

    /**
     * @var string
     */
    public $viewFolderName = 'doctor_type';

    /**
     * AuthorController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'doctor_type';
        $this->baseData['baseRouteName'] = $this->baseData['baseRouteName'] . '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = DoctorTypeHelper::getLang();
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->baseData['allData'] = DoctorType::orderBy('created_at','desc')->paginate(25);

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName.'.index', $this->baseData);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        try {
            $this->baseData['routes']['create_form_data'] = DoctorTypeHelper::getRoutes()['create_data'];

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
            $this->baseData['routes'] = DoctorTypeHelper::getRoutes();
            $this->baseData['routes']['upload_image'] = route(config('cms.admin.base_route_name') .'.image.upload');

            if ($request->get('id')) {
                $item = DoctorType::findOrFail($request->get('id'))->load(['translations']);
                $locales = TranslationFieldsWithLocale::setTranslations($item->translations)->setTranslationFields((new DoctorTypeTranslation())->getFillable())
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
     * @param DoctorTypeStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DoctorTypeStoreRequest $request)
    {
        try {
            $saveData = Arr::except($request->except(['id'])['main'], array_merge(['profile'],(new DoctorTypeTranslation())->getFillable()));
            if ($request->get('id')) {
                $item = DoctorType::findOrFail($request->get('id'));
                $item->update($saveData);
            } else {
                DoctorType::create($saveData);
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
            $this->baseData['routes']['create_form_data'] = DoctorTypeHelper::getRoutes()['create_data'];

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
            DoctorType::findOrFail($request->get('id'))->delete();
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
            DoctorType::findOrFail($request->get('id'))->update(['status' => $request->get('status')]);
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['update_status_successfully'], 200,  $this->baseData );
    }


}
