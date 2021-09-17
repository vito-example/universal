<?php

namespace App\Modules\Event\Http\Controllers\Api\Client;

use App\Modules\Event\Http\Resources\Calendar\CustomerCalendarResource;
use App\Modules\Event\Http\Resources\Event\EventListResource;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Laravel\Jetstream\Jetstream;
use SeoData;

class CalendarController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Calendar/Index',[
            'current_date' => now()->format('Y-m-d'),
            'seo' => SeoData::setTitle(__('seo.calendar.title'))
                ->setDescription(__('seo.calendar.description'))
                ->setKeywords(__('seo.calendar.keywords'))
                ->setOgTitle(__('seo.calendar.title'))
                ->setOgDescription(__('seo.calendar.description'))->getSeoData()
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCalendarData()
    {
        $calendarData = new CustomerCalendarResource(auth()->user());

        return response()->json([
            'data'  => [
                'calendar_data' => $calendarData
            ]
        ]);
    }

}
