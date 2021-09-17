<?php
/**
 *  app/Modules/Customer/Http/Controllers/Web/Admin/DirectionController.php
 *
 * Date-Time: 06.07.21
 * Time: 17:27
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Modules\Customer\Http\Controllers\Web\Admin;


use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Customer\Helpers\CollectionHelper;
use App\Modules\Customer\Helpers\DirectionHelper;
use App\Modules\Customer\Http\Requests\Admin\DirectionStoreRequest;
use App\Modules\Customer\Http\Resources\Direction\DirectionItemResource;
use App\Modules\Customer\Http\Resources\Direction\DirectionListResource;
use App\Modules\Customer\Models\Direction;
use App\Modules\Customer\Models\Translations\DirectionTranslation;
use App\Utilities\ServiceResponse;
use Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Log;
use TranslationFieldsWithLocale;


/**
 * Class DirectionController
 * @package App\Modules\Customer\Http\Controllers\Web\Admin
 */
class DirectionController extends BaseController
{

    /**
     * @var string
     */
    protected string $baseModuleName = 'customer::';

    /**
     * @var string
     */
    public $moduleTitle = 'direction';

    /**
     * @var string
     */
    public $viewFolderName = 'direction';


    /**
     * DirectionController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'direction';
        $this->baseData['baseRouteName'] .= '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = DirectionHelper::getLang();
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function index()
    {
        // I can this method because I known that rows will be less than 100. If row increase change methodology!..
        $this->baseData['allData'] = Direction::get();

        $data = $this->baseData['allData'];

        $generator = static function (Collection $level) use ($data, &$generator) {
            foreach ($level->sortByDesc('created_at') as $item) {
                yield $item;

                yield from $generator($data->where('parent_id', $item->id));
            }
        };

        $results = LazyCollection::make(function () use ($data, $generator) {
            yield from $generator($data->where('parent_id', null));
        })->flatten()->collect();

        $this->baseData['allData'] = CollectionHelper::paginate($results, 25);

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.index', $this->baseData);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        try {
            $this->baseData['routes']['create_form_data'] = DirectionHelper::getRoutes()['create_data'];
        } catch (\Exception $exception) {
            return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.create', ServiceResponse::error($exception->getMessage()));
        }

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.create', ServiceResponse::success($this->baseData));
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createData(Request $request): JsonResponse
    {
        try {
            $this->baseData['routes'] = DirectionHelper::getRoutes();
            $this->baseData['routes']['upload_image'] = route(config('cms.admin.base_route_name') . '.image.upload');

            $directions = (new DirectionListResource())->getAndSetCrudResources((int)$request->get('id'), true)->toArray();
            $this->baseData['options']['directions'] = array_merge([[
                'value' => null,
                'label' => $this->baseData['trans_text']['no_one']
            ]],
                DirectionHelper::getDirectionRecursiveToArray($directions, (int)$request->get('id'))
            );

            if ($request->get('id')) {
                $item = Direction::findOrFail($request->get('id'))->load(['translations']);
                $locales = TranslationFieldsWithLocale::setTranslations($item->translations)->setTranslationFields((new DirectionTranslation())->getFillable())
                    ->generateFieldsWithLocales()->getFieldsWithLocales();

                $this->baseData['item']['main'] = $locales;
                $this->baseData['item']['main'] = array_merge($this->baseData['item']['main'], $item->only($item->getFillable()));
            }
        } catch (\Exception $ex) {
            Log::error('Error during roles index page', ['error' => $ex, 'message' => $ex->getMessage(), 'data' => $request->all()]);
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification(__('Filter role successfully'), 200, $this->baseData);
    }

    /**
     * @param \App\Modules\Customer\Http\Requests\Admin\DirectionStoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(DirectionStoreRequest $request)
    {
        try {
            $saveData = Arr::except($request->except(['id'])['main'], array_merge(['profile'], (new DirectionTranslation())->getFillable()));
            DB::connection()->beginTransaction();

            if ($request->get('id')) {
                $item = Direction::findOrFail($request->get('id'));
                $item->update($saveData);

            } else {
                $item = Direction::create($saveData);
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id = '')
    {
        try {
            $this->baseData['routes']['create_form_data'] = DirectionHelper::getRoutes()['create_data'];

            $this->baseData['id'] = $id;
        } catch (\Exception $ex) {
            return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::error($ex->getMessage()));
        }

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.edit', ServiceResponse::success($this->baseData));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function destroy(Request $request): JsonResponse
    {
        try {
            $direction = Direction::findOrFail($request->get('id'))->delete();
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
            Direction::findOrFail($request->get('id'))->update(['status' => $request->get('status')]);
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
    public function search(Request $request): JsonResponse
    {
        $customers = Direction::filter($request->all())->get();

        return response()->json([
            'data' => [
                'items' => $customers->map(function (Direction $item) {
                    return (new DirectionItemResource($item, true, true))->toArray();
                })
            ]
        ]);
    }
}
