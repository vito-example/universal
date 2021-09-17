<?php
/**
 *  app/Modules/Company/Http/Controllers/Web/Admin/CompanyEmployeeController.php
 *
 * Date-Time: 22.07.21
 * Time: 09:38
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Company\Http\Controllers\Web\Admin;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Company\Exports\ExportCompanyEmployee;
use App\Modules\Company\Helpers\CompanyEmployeeHelper;
use App\Modules\Company\Helpers\CompanyHelper;
use App\Modules\Company\Http\Requests\Admin\CompanyEmployeeStoreRequest;
use App\Modules\Company\Http\Requests\Admin\CompanyStoreRequest;
use App\Modules\Company\Http\Resources\Company\CompanyItemResource;
use App\Modules\Company\Http\Resources\CompanyEmployee\CompanyEmployeeEditItemResource;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyEmployee;
use App\Utilities\ServiceResponse;
use DB;
use Excel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Log;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class CompanyEmployeeController
 * @package App\Modules\Company\Http\Controllers\Web\Admin
 */
class CompanyEmployeeController extends BaseController
{

    protected string $baseModuleName = 'company::';

    /**
     * @var string
     */
    public string $moduleTitle = 'company_employee';

    /**
     * @var string
     */
    public string $viewFolderName = 'company_employee';

    /**
     * AuthorController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'company_employee';
        $this->baseData['baseRouteName'] .= '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = CompanyEmployeeHelper::getLang();
    }

    /**
     * @param Request $request
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filterData = $request->all();
        if (!empty($filterData['company_ids'])) {
            $filterData['company_ids'] = explode(',', $filterData['company_ids']);
        }
        $this->baseData['allData'] = CompanyEmployee::filter($filterData)
            ->with('company')
            ->hasCompany()
            ->orderBy('created_at', 'desc')
            ->paginate(25);
        $this->baseData['options'] = [
            'companies' => Company::all()->map(function (Company $company) {
                return (new CompanyItemResource($company))->toArray();
            })
        ];
        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.index', $this->baseData);
    }

    /**
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        try {
            $this->baseData['routes']['create_form_data'] = CompanyHelper::getRoutes()['create_data'];

        } catch (\Exception $ex) {
            return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.create', ServiceResponse::error($ex->getMessage()));
        }

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.create', ServiceResponse::success($this->baseData));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createData(Request $request): JsonResponse
    {
        try {
            $this->baseData['routes'] = CompanyEmployeeHelper::getRoutes();
            $this->baseData['options'] = [];

            if ($request->get('id')) {
                $item = CompanyEmployee::findOrFail($request->get('id'));
                $this->baseData['item'] = (new CompanyEmployeeEditItemResource($item))->toArray();
            }
        } catch (\Exception $ex) {
            Log::error('Error during roles index page', ['error' => $ex, 'message' => $ex->getMessage(), 'data' => $request->all()]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification(__('Filter role successfully'), 200, $this->baseData);
    }

    /**
     * @param \App\Modules\Company\Http\Requests\Admin\CompanyEmployeeStoreRequest $request
     *
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(CompanyEmployeeStoreRequest $request)
    {
        try {
            $saveData = $request->only('main');
            DB::connection()->beginTransaction();
            if ($request->get('id')) {
                $item = CompanyEmployee::findOrFail($request->get('id'));
                $item->update($saveData['main']);
            }
            DB::connection()->commit();

        } catch (\Exception $ex) {
            DB::connection()->rollBack();

            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        } catch (\Throwable $e) {
            DB::connection()->rollBack();
            return ServiceResponse::jsonNotification($e->getMessage(), $e->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200, $this->baseData);
    }

    /**
     * @param string $id
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id = '')
    {
        try {
            $this->baseData['routes']['create_form_data'] = CompanyEmployeeHelper::getRoutes()['create_data'];
            $this->baseData['id'] = $id;
        } catch (\Exception $ex) {
            return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::error($ex->getMessage()));
        }

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::success($this->baseData));
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, $id)
    {
        $item = CompanyEmployee::with([
            'company'
        ])->hasCompany()
            ->where('id', $id)->firstOrFail();
        $this->baseData['item'] = $item;

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.show', $this->baseData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            CompanyEmployee::findOrFail($request->get('id'))->delete();
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['delete_successfully'], 200, $this->baseData);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateStatus(Request $request)
    {
        try {
            Company::findOrFail($request->get('id'))->update(['status' => $request->get('status')]);
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['update_status_successfully'], 200, $this->baseData);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $customers = Company::filter($request->all())->get();

        return response()->json([
            'data' => [
                'items' => $customers->map(function (Company $item) {
                    return (new CompanyItemResource($item))->toArray();
                })
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request): BinaryFileResponse
    {
        return Excel::download(new ExportCompanyEmployee($request->all()), 'employee.xlsx');
    }

}
