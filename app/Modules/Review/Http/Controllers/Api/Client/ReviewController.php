<?php


namespace App\Modules\Review\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Modules\Event\Models\Event;
use App\Modules\Review\Services\ReviewService;
use Illuminate\Http\Request;
use Log;
use Mockery\Exception;

class ReviewController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $event = Event::findOrFail($request->get('event_id'));

        try {
            (new ReviewService)->setModel($event)
                ->setUser(auth()->user())
                ->setContent($request->get('content'))
                ->setRate($request->get('value'))
                ->createReview();

            return back()->with('flash', [
                'message' => 'Status updated successfully.',
            ]);
        } catch (Exception $ex) {
            Log::error($ex);
        }

        return back()->with('flash', [
            'message' => 'Something Happened.',
        ]);
    }
}