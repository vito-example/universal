<?php


namespace App\Modules\Review\Http\Controllers\Web\Admin;

use App\Modules\Admin\Http\Controllers\BaseController;
use App\Modules\Review\Helpers\ReviewHelper;
use App\Modules\Review\Models\Review;
use App\Modules\Review\Services\ReviewService;
use Illuminate\Http\Request;
use Log;
use Mockery\Exception;

class ReviewController extends BaseController
{
    /**
     * @var string
     */
    protected string $baseModuleName = 'review::';

    /**
     * @var string
     */
    public string $moduleTitle = 'review';

    /**
     * @var string
     */
    public string $viewFolderName = 'review';

    /**
     * AuthorController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->successCreateText = $this->moduleTitle . $this->successCreateText;
        $this->successUpdateText = $this->moduleTitle . $this->successUpdateText;
        $this->successDeleteText = $this->moduleTitle . $this->successDeleteText;
        $this->baseData['moduleKey'] = 'review';
        $this->baseData['baseRouteName'] .= '.' . $this->baseData['moduleKey'] . '.';
        $this->baseData['trans_text'] = ReviewHelper::getLang();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->baseData['updateRoute'] = ReviewHelper::getRoutes()['update_status'];
        $this->baseData['reviews'] = (new ReviewService)->getAll();

        return view($this->baseModuleName . $this->baseAdminViewName . $this->viewFolderName . '.index', $this->baseData);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        $review = Review::findOrFail($request->get('review_id'));

        try {
            (new ReviewService)->setReview($review)
                ->updateStatus($request->get('status'));

            return response()->json(['message' => 'Status updated successfully.']);
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return response()->json(['message' => 'Something Happened.']);
    }
}