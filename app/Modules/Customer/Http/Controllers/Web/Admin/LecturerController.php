<?php

namespace App\Modules\Customer\Http\Controllers\Web\Admin;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Base\Models\Image;
use App\Modules\Customer\Exports\ExportLecturers;
use App\Modules\Customer\Helpers\LecturerHelper;
use App\Modules\Customer\Http\Requests\Admin\LecturerStoreRequest;
use App\Modules\Customer\Http\Resources\Direction\DirectionItemResource;
use App\Modules\Customer\Http\Resources\Direction\DirectionListResource;
use App\Modules\Customer\Http\Resources\Lecturer\LecturerItemResource;
use App\Modules\Customer\Models\Direction;
use App\Modules\Customer\Models\Lecturer;
use App\Modules\Customer\Models\Translations\LecturerTranslation;
use App\Utilities\ServiceResponse;
use Excel;
use GetImageWithType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Log;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use TranslationFieldsWithLocale;

class LecturerController extends BaseController
{

    protected string $baseModuleName = 'customer::';

    /**
     * @var string
     */
    public $moduleTitle = 'lecturer';

    /**
     * @var string
     */
    public $viewFolderName = 'lecturer';

    /**
     * AuthorController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'lecturer';
        $this->baseData['baseRouteName'] = $this->baseData['baseRouteName'] . '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = LecturerHelper::getLang();
    }

    /**
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $filterData = $request->all();
        if (!empty($filterData['direction_ids'])) {
            $filterData['direction_ids'] = explode(',', $filterData['direction_ids']);
        }
        $this->baseData['allData'] = Lecturer::with('translations', 'directions.translations')->filter($filterData)->orderBy('created_at', 'desc')->paginate(25);
        $this->baseData['options'] = [
            'directions' => Direction::all()->map(function (Direction $item) {
                return (new DirectionItemResource($item))->toArray();
            }),
            'statuses'  => [
                [
                    'value' => 0,
                    'label' => __('admin.customer.all')
                ],
                [
                    'value' => -1,
                    'label' => __('admin.customer.not_active')
                ],
                [
                    'value' => 1,
                    'label' => __('admin.customer.active')
                ]
            ]
        ];
        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.index', $this->baseData);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        try {
            $this->baseData['routes']['create_form_data'] = LecturerHelper::getRoutes()['create_data'];

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
            $this->baseData['routes'] = LecturerHelper::getRoutes();
//            $this->baseData['routes']['filters']['directions'] = route('admin.direction.search');
            $this->baseData['routes']['upload_image'] = route(config('cms.admin.base_route_name') . '.image.upload');
            $this->baseData['options'] = [];
            $this->baseData['directions'] = (new DirectionListResource())->getAndSetCrudResources(0, true, true)->toArray();


            if ($request->get('id')) {
                $item = Lecturer::with('directions')->findOrFail($request->get('id'))->load(['translations']);
                $locales = TranslationFieldsWithLocale::setTranslations($item->translations)->setTranslationFields((new LecturerTranslation())->getFillable())
                    ->generateFieldsWithLocales()->getFieldsWithLocales();

                $this->baseData['item']['main'] = $locales;
                $this->baseData['item']['main'] = array_merge($this->baseData['item']['main'], $item->only($item->getFillable()));

                $images = GetImageWithType::setImages($item->images->toArray() ?: [])->generateWithType()->getImagesWithType();
                $this->baseData['item']['main']['images'] = $images;

                $this->baseData['item']['main']['directions'] = $item->directions ? $item->directions()->pluck('id')->toArray() : [];
            };
        } catch (\Exception $ex) {
            Log::error('Error during roles index page', ['error' => $ex, 'message' => $ex->getMessage(), 'data' => $request->all()]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification(__('Filter role successfully'), 200, $this->baseData);
    }

    /**
     * @param LecturerStoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(LecturerStoreRequest $request)
    {
        try {
            $saveData = Arr::except($request->except(['id'])['main'], array_merge(['profile'], (new LecturerTranslation())->getFillable()));
            DB::connection()->beginTransaction();


            if ($request->get('id')) {

                $item = Lecturer::findOrFail($request->get('id'));
                $item->update($saveData);

                // remove old directions
                $item->directions()->detach();

                if (isset($saveData['images'])) {
                    $this->saveImages($item, $saveData['images']);
                }


            } else {
                $item = Lecturer::create($saveData);

                if (isset($saveData['images'])) {
                    $this->saveImages($item, $saveData['images']);
                }
            }

            if (isset($saveData['directions'])) {
                $directions = Direction::whereIn('id',$saveData['directions'])->get();
                $directionIds = [];
                foreach ($directions as $direction) {
                    $directionIds = [...$directionIds,...$direction->getAllChildren()->pluck('id')->toArray()];
                    $directionIds [] = $direction->id;
                }
                $item->directions()->sync(array_unique($directionIds));
            }

            DB::connection()->commit();

        } catch (\Exception $ex) {
            DB::connection()->rollBack();

            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200, $this->baseData);
    }

    /**
     * @param string $id
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(string $id = '')
    {
        try {
            $this->baseData['routes']['create_form_data'] = LecturerHelper::getRoutes()['create_data'];
            $this->baseData['id'] = $id;
        } catch (\Exception $ex) {
            return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::error($ex->getMessage()));
        }

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::success($this->baseData));
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, int $id)
    {
        $item = Lecturer::with([
            'directions',
            'images'
        ])->where('id', $id)->firstOrFail();

        $this->baseData['item'] = $item;
        $this->baseData['profile_image'] = $item->getImageByKey('profile');

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
            Lecturer::findOrFail($request->get('id'))->delete();
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
    public function updateStatus(Request $request): JsonResponse
    {
        try {
            Lecturer::findOrFail($request->get('id'))->update(['status' => $request->get('status')]);
        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['update_status_successfully'], 200, $this->baseData);
    }


    /**
     * @param Lecturer $lecturer
     * @param array $images
     */
    private function saveImages(Lecturer $lecturer, array $images = [])
    {
        $itemImages = $lecturer->images;

        foreach ($images as $key => $image) {
            $imageModel = Image::findOrFail($image['item']['id']);
            $imageModel->imageable()->associate($lecturer);
            $imageModel->save();
            $itemImages = $itemImages->reject(function ($img) use ($imageModel) {
                return $img->id === $imageModel->id;
            });
        }

        $itemImages->map(function ($modelImage) {
            $modelImage->delete();
        });
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $customers = Lecturer::filter($request->only('full_name'))->get();

        return response()->json([
            'data' => [
                'items' => $customers->map(function (Lecturer $lecturer) {
                    return (new LecturerItemResource($lecturer))->toArray();
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
        return Excel::download(new ExportLecturers($request->all()), 'lecturers.xlsx');
    }
}
