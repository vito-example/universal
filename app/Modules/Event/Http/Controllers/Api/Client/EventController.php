<?php

namespace App\Modules\Event\Http\Controllers\Api\Client;

use App\Models\User;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyEmployee;
use App\Modules\Company\Models\CompanyMember;
use App\Modules\Company\Models\UserEmployeeConnection;
use App\Modules\Customer\Http\Resources\Direction\DirectionItemResource;
use App\Modules\Customer\Http\Resources\Direction\DirectionListResource;
use App\Modules\Customer\Models\Direction;
use App\Modules\Event\Exceptions\EventIsNotOrganizedException;
use App\Modules\Event\Exceptions\EventNotFoundException;
use App\Modules\Event\Exceptions\UserAlreadyIsInAttendeesException;
use App\Modules\Event\Http\Requests\Client\Event\RegisterEvent;
use App\Modules\Event\Http\Requests\Client\Event\RequestEvent;
use App\Modules\Event\Http\Resources\Event\EventFormOptions;
use App\Modules\Event\Http\Resources\Event\EventSessionStatusOptions;
use App\Modules\Event\Http\Resources\Event\EventStatusOptions;
use App\Modules\Event\Http\Resources\Event\EventTypeOptions;
use App\Modules\Event\Http\Resources\EventSessionRequest\EventSessionRequestStatusOptions;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Models\EventSession;
use App\Modules\Event\Models\EventSessionAttempt;
use App\Modules\Event\Models\EventSessionRequest;
use App\Modules\Event\Models\Translations\EventTranslation;
use App\Modules\Landing\Http\Resources\Event\EventItemResource;
use App\Modules\Review\Services\ReviewService;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Jetstream;
use SeoData;
use View;

class EventController extends Controller
{
    protected array $directionArray = [];

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function trainings(Request $request): \Inertia\Response
    {
        $allSeoData = (new EventItemResource())->toListSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Landing/Trainings/Index', [
            'items' => $this->getTrainingsByForm(EventFormOptions::FORM_OFFLINE, $request),
            'seo' => $allSeoData,
            'route' => route('trainings.index'),
            'directions' => (new DirectionListResource())->getAndSetCrudResources(0, true, true)->toArray(),
            'places' => $this->getPlaces(),
            'selectedDirections' => $request->directions ?? [],
            'place' => $request->place ?? '',
            'types' => (new EventTypeOptions())->getFilterTypes(),
            'type' => $request->type ?? '',
            'trainingType' => 'offline'
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function trainingsOnline(Request $request): \Inertia\Response
    {
        $allSeoData = (new EventItemResource())->toListSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });


        return Jetstream::inertia()->render($request, 'Landing/Trainings/Index', [
            'items' => $this->getTrainingsByForm(EventFormOptions::FORM_ONLINE, $request),
            'seo' => $allSeoData,
            'route' => route('trainings.online'),
            'directions' => (new DirectionListResource())->getAndSetCrudResources(0, true, true)->toArray(),
            'places' => $this->getPlaces(),
            'selectedDirections' => $request->directions ?? [],
            'place' => $request->place ?? '',
            'types' => (new EventTypeOptions())->getFilterTypes(),
            'type' => $request->type ?? '',
            'trainingType' => 'online'
        ]);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Inertia\Response
     */
    public function trainingsShow(Request $request, string $slug): \Inertia\Response
    {
        $event = Event::with([
            'translations',
            'images'
        ])
            ->where('status', EventStatusOptions::STATUS_ORGANIZED)
            ->where('id', getIdFromSlug($slug))->firstOrFail();

        $allSeoData = (new EventItemResource($event))->toSeoData();
        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Landing/Trainings/Show', [
            'item' => (new EventItemResource($event))->toArrayForShow(),
            'reviews' => (new ReviewService)->setModel($event)->getReviews(),
            'similarEvents' => (new EventItemResource($event))->getSimilarEvents(),
            'seo' => $allSeoData,
            'directions' => $event->directions ? $event->directions->map(function ($direction) {
                return (new DirectionItemResource($direction))->toQuery();
            }) : [],
            'registerSessions' => auth()->user() ? auth()->user()->trainings($event) : []
        ]);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Inertia\Response
     */
    public function trainingRegisterView(Request $request, string $slug): \Inertia\Response
    {
        $event = Event::with([
            'translations',
            'sessions',
        ])
            ->where('status', EventStatusOptions::STATUS_ORGANIZED)
            ->where('id', getIdFromSlug($slug))->firstOrFail();

        $allSeoData = SeoData::setTitle(__('seo.training_register.title'))
            ->setDescription(__('seo.training_register.description'))
            ->setKeywords(__('seo.training_register.description'))
            ->setOgTitle(__('seo.training_register.title'))
            ->setOgDescription(__('seo.training_register.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Landing/Trainings/Register', [
            'item' => (new EventItemResource($event))->toRegisterItem(),
        ]);
    }

    /**
     * @param RegisterEvent $request
     * @param string $slug
     * @return \Inertia\Response
     * @throws ValidationException|\Throwable
     */
    public function trainingRegister(RegisterEvent $request, string $slug): \Inertia\Response
    {
        try {
            $event = Event::with([
            ])
                ->where('status', EventStatusOptions::STATUS_ORGANIZED)
                ->where('id', getIdFromSlug($slug))->firstOrFail();
        } catch (ModelNotFoundException $ex) {
            throw ValidationException::withMessages([
                'validation_error' => [__('validation.Training_not_found')],
            ]);
        }

        if (!$event->isOrganized()) {
            throw ValidationException::withMessages([
                'validation_error' => [__('validation.Training_Is_not_ar_organized')],
            ]);
        }

        try {
            $session = EventSession::with([

            ])
                ->where('id', $request->session_id)->firstOrFail();
        } catch (ModelNotFoundException $ex) {
            throw ValidationException::withMessages([
                'validation_error' => [__('validation.Session_not_found')],
            ]);
        }
        if ($request->mode === 'personal') {
            $this->checkFreePlace($session);

            $userEmployeeConnection = UserEmployeeConnection::where('morphable_type', User::class)->where('morphable_id', auth()->id())->first();
            if ($session->isInAttendees($userEmployeeConnection->id)) {
                throw ValidationException::withMessages([
                    'validation_error' => [__('validation.User_already_is_in_attendees')],
                ]);
            }
            $session->attendees()->syncWithoutDetaching([
                $userEmployeeConnection->id
            ]);
        } else {
            // New Company
            $employeeIds = $request->employees ?? [];
            DB::beginTransaction();
            if (null === $request->company_id) {
                $company = Company::create([
                    'title' => $request['company']['title'],
                    'identify_id' => $request['company']['identify_id'],
                    'address' => $request['company']['address'],
                    'description' => $request['company']['description']
                ]);

                $company->ownerMembers()->updateOrCreate([
                    'user_id' => auth()->id(),
                    'company_id' => $company->id,
                    'role' => CompanyMember::ROLE_OWNER
                ]);
                $company->save();
            } else {
                $company = Company::where('id',$request->company_id)->firstOrFail();
            }
            if ($request->company_employee[0]['name'] != '') {
                foreach ($request['company_employee'] as $employee) {
                    $employee = new CompanyEmployee([
                        'company_id' => $company->id,
                        'name' => $employee['name'],
                        'email' => $employee['email'],
                        'phone' => $employee['phone'],
                        'role' => $employee['role'],
                    ]);
                    $employee->save();
                    $employeeIds[] = $employee->id;
                }
            }

            DB::commit();

            if (!count($employeeIds)) {
                throw ValidationException::withMessages([
                    'validation_error' => [__('validation.Please_checked_employee')],
                ]);
            }
            $this->checkFreePlace($session);

            $userEmployeeConnection = UserEmployeeConnection::where('morphable_type', CompanyEmployee::class)->whereIn('morphable_id', $employeeIds)->pluck('id')->toArray();
            $session->attendees()->syncWithoutDetaching($userEmployeeConnection);



        }

        return Jetstream::inertia()->render($request, 'Landing/Trainings/Register', [
            'item' => (new EventItemResource($event))->toRegisterItem(),
            'message' => __('training.register_successfully')
        ]);
    }

    /**
     * @param Request $request
     * @param string $slug
     * @return \Inertia\Response
     */
    public function trainingRequestView(Request $request, string $slug): \Inertia\Response
    {
        $event = Event::with([
            'translations',
            'sessions',
        ])
            ->where('status', EventStatusOptions::STATUS_ORGANIZED)
            ->where('id', getIdFromSlug($slug))->firstOrFail();

        $allSeoData = SeoData::setTitle(__('seo.training_request.title'))
            ->setDescription(__('seo.training_request.description'))
            ->setKeywords(__('seo.training_request.description'))
            ->setOgTitle(__('seo.training_request.title'))
            ->setOgDescription(__('seo.training_request.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Landing/Trainings/Request', [
            'item' => (new EventItemResource($event))->toRequestItem(),
        ]);
    }

    /**
     * @param RegisterEvent $request
     * @param string $slug
     * @return \Inertia\Response
     * @throws ValidationException
     */
    public function trainingRequest(RequestEvent $request, string $slug): \Inertia\Response
    {
        try {
            $event = Event::with([
            ])
                ->where('status', EventStatusOptions::STATUS_ORGANIZED)
                ->where('id', getIdFromSlug($slug))->firstOrFail();
        } catch (ModelNotFoundException $ex) {
            throw ValidationException::withMessages([
                'validation_error' => [__('validation.Training_not_found')],
            ]);
        }

        EventSessionRequest::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'date' => $request->start_date ? Carbon::parse($request->start_date) : null,
            'max_person' => $request->max_person ?? 1,
            'status' => EventSessionRequestStatusOptions::STATUS_PENDING
        ]);

        $item = (new EventItemResource($event))->toRequestItem();
        $item['pending'] = false;

        return Jetstream::inertia()->render($request, 'Landing/Trainings/Request', [
            'item' => $item,
            'message' => __('training.request_successfully')
        ]);
    }

    /**
     * @param int $form
     * @param Request $request
     * @return LengthAwarePaginator
     */
    private function getTrainingsByForm(int $form, Request $request): LengthAwarePaginator
    {
        /** @var $trainings LengthAwarePaginator */
        $trainings = Event::query();

        if ($request->directions) {
            $directions = $request->directions;
            foreach ($directions as $direction) {
                $trainings->whereHas('directions', function ($query) use ($direction) {
                    $query->where('direction_id', $direction);
                });
            }
        }

        if ($request->place) {
            $place = $request->place;

            $trainings->whereHas('translations', function ($query) use ($place) {
                $query->where('place', 'like', '%' . $place . '%');
            });
        }

        if ($request->type) {
            $trainings->where('type', $request->type);
        }

        $trainings = $trainings->with([
            'translations',
            'images'
        ])
            ->status(EventStatusOptions::STATUS_ORGANIZED)
            ->form($form)
            ->paginate($request->get('total', 9));

        $trainingData = collect();
        foreach ($trainings->getIterator() as $training) {
            $trainingData->push((new EventItemResource($training))->toListItem());
        }

        $trainings->setCollection($trainingData);

//        $directions = (new DirectionListResource())->getAndSetCrudResources(0, true, true)->toArray();
//        $this->parseTree($directions);

        return $trainings;
    }

    /**
     * @return EventTranslation[]|array|Builder[]|Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    private function getPlaces()
    {
        $places = EventTranslation::where('locale', app()->getLocale())->whereNotNull('place')->groupBy('place')->get();
        $items[] = [
            'label' => __('training.ჩატარების ადგილი'),
            'value' => '',
        ];

        if ($places) {
            foreach ($places as $eventTranslation) {
                $items [] = [
                    'label' => $eventTranslation->place,
                    'value' => $eventTranslation->place
                ];
            }
        }

        return $items;
    }

    /**
     * @param array $array
     * @param int $level
     */
    public function parseTree(array $array, int $level = 1)
    {
        foreach ($array as $key => $item) {
            $prefix = '';
            if ($level === 3) {
                $prefix = '--';
            }
            if ($level === 2) {
                $prefix = '-';
            }
            $this->directionArray [] = [
                'value' => $item['id'],
                'label' => $prefix . $item['label']
            ];
            if (count($item['children'])) {
                $this->parseTree($item['children'], $level + 1);
            }
        }
    }

    /**
     * @param $session
     * @param int $personTotal
     * @throws ValidationException
     */
    private function checkFreePlace($session, int $personTotal = 1)
    {
        // If place not exist
        $sessionFreePlace = $session->max_person - $session->register_personCount;
        if ($sessionFreePlace < $personTotal) {
            EventSessionAttempt::create([
                'session_id' => $session->id,
                'user_id' => auth()->id(),
                'person_total' => $personTotal
            ]);
            if ($sessionFreePlace === 0) {
                throw ValidationException::withMessages([
                    'validation_error' => [__('validation.session_already_fully.will_contact_you')],
                ]);
            }
            throw ValidationException::withMessages([
                'validation_error' => [$sessionFreePlace . ' - ' . __('validation.seats_left_in_the_session.you_try_to_register') . ' - ' . $personTotal],
            ]);
        }
    }
}
