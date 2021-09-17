<?php

namespace App\Modules\Admin\Http\Controllers\Admin;

use App\Modules\Admin\Exports\LangFileExport;
use App\Modules\Admin\Helper\TextHelper;
use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Admin\Http\Requests\Text\SaveTextRequest;
use App\Modules\Admin\Imports\LangFileImport;
use App\Modules\Admin\Models\Statics\Text;
use App\Modules\Admin\Repositories\Contracts\ITextRepository;
use App\Modules\Admin\Utilities\LangFiles;
use App\Utilities\ServiceResponse;
use Excel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use TextService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class TextController extends BaseController
{
    /**
     * @var string
     */
    public $viewFolderName = 'text';


    /**
     * TextController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->baseData['moduleKey'] = 'text';
        $this->baseData['baseRouteName'] = $this->baseData['baseRouteName'] . '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = TextHelper::getLang();
    }

    /**
     * @param SaveTextRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SaveTextRequest $request)
    {
        try {
            $textService = TextService::postEdit($request->get('texts'),$request->get('file'), true);
            $textService->exportTranslations($request->get('file'),$request->get('file') === '_json');

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['save_successfully'], 200,  $this->baseData );
    }

    /**
     * @param LangFiles $langFile
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(LangFiles $langFile, Request $request)
    {
        $this->baseData['routes']['index_data'] = route($this->baseData['baseRouteName'] . 'index_data');

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName . '.index', $this->baseData);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @return LengthAwarePaginator
     * @var array
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexData(Request $request)
    {
        try {
            $langFiles = [];

            foreach(config('language_manager.locales') as $locale) {
                $request->request->add(['locale' => $locale]);
                foreach(Text::filter($request->all())->get() as $langText){
                    $langFiles[$langText->key][$locale] = $langText->value;
                }
            }

            $this->baseData['lang_files'] = $this->paginate(collect($langFiles), $request->get('total',25),$request->get('page',1));
            $this->baseData['locales'] = config('language_manager.locales');
            $this->baseData['groups'] = Text::where('group', '!=', $request->get('group'))->distinct()
                ->get('group')->pluck('group')->toArray();

            // Set routes.
            $this->baseData['routes']['import'] =route($this->baseData['baseRouteName'] . 'import');
            $this->baseData['routes']['export'] =route($this->baseData['baseRouteName'] . 'export');
            $this->baseData['routes']['update'] = route($this->baseData['baseRouteName'] . 'update');
            $this->baseData['routes']['store'] = route($this->baseData['baseRouteName'] . 'store');
            $this->baseData['routes']['delete'] = route($this->baseData['baseRouteName'] . 'delete');

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification('get_index_data', 200,  $this->baseData );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $textService = TextService::postEdit($request->get('texts'), $request->get('file'));
            $textService->exportTranslations($request->get('file'), $request->get('file') === '_json');

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['update_successfully'], 200,  $this->baseData );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try {
            // Delete text.
            $textService = TextService::deleteText($request);

            // Save in file.
            $textService->exportTranslations($request->get('file'),$request->get('file') === '_json');

        } catch (\Exception $ex) {
            return ServiceResponse::jsonNotification($ex->getMessage(), $ex->getCode(), []);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['delete_successfully'], 200,  $this->baseData );
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(Request $request)
    {
        $langFiles = Text::filter($request->all())->get();
        return Excel::download(new LangFileExport($langFiles), 'lang_files_'.now()->toDateTimeString().'.xlsx');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        $uploadedFile = $request->file('file');
        $array = Excel::toArray(new LangFileImport(), $uploadedFile);

        $groups = [];
        foreach (collect($array[0])->chunk(100) as $columnsChunk) {
            foreach($columnsChunk as $columns) {
                Text::updateOrCreate([
                    'locale'    => $columns['locale'],
                    'group'     => $columns['group'],
                    'key'       => $columns['key']
                ],[
                    'value'     => $columns['value'],
                    'status'    => Text::STATUS_CHANGED
                ]);
                if (!in_array($columns['group'],$groups)) {
                    $groups[] = $columns['group'];
                }
            }
        }

        foreach($groups as $group) {
            TextService::exportTranslations($group);
        }

        return ServiceResponse::jsonNotification($this->baseData['trans_text']['import_successfully'], 200,  $this->baseData );
    }

}
