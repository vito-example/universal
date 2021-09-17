<?php

namespace App\Modules\Pages\Http\Controllers\Admin;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Base\Http\Resources\Admin\Config\ConfigResource;
use App\Modules\Pages\Helpers\StaticPageHelper;
use App\Modules\Pages\Helpers\SubscriberHelper;
use App\Modules\Pages\Models\StaticPage;
use App\Modules\Pages\Models\Subscriber;
use App\Traits\ExportTrait;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class SubscriberController extends BaseController
{
    use ExportTrait;

    protected string $baseModuleName = 'pages::';

    /**
     * @var string
     */
    public $moduleTitle = 'subscriber';

    /**
     * @var string
     */
    public $viewFolderName = 'subscriber';

    /**
     * StaticPageController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'subscriber';
        $this->baseData['baseRouteName'] = $this->baseData['baseRouteName'] . '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = SubscriberHelper::getLang('subscriber');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $subscribers = Subscriber::orderBy('id','desc');

        if ($request->get('limit')) {
            $this->baseData['per_page'] = $request->get('limit',25);
        } else {
            $this->baseData['per_page'] = !empty($config['admin_paginate_limit']) ? (int)$config['admin_paginate_limit'] : 25;
        }

        $this->baseData['allData'] = $subscribers->paginate($this->baseData['per_page']);

        return view($this->baseModuleName   . $this->baseAdminViewName . $this->viewFolderName.'.index', $this->baseData);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        $subscribers = Subscriber::orderBy('id','desc')->get();
        return $this->baseExport($subscribers,'subscribers_' . now()->toDateTimeString());
    }

}
