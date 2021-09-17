<?php

namespace App\Modules\Landing\Http\Controllers\Client;

use App\Modules\Customer\Http\Resources\Direction\DirectionListResource;
use App\Modules\Customer\Models\Direction;
use App\Modules\Customer\Models\Lecturer;
use App\Modules\Event\Http\Resources\Event\EventFormOptions;
use App\Modules\Event\Http\Resources\Event\EventStatusOptions;
use App\Modules\Event\Models\Event;
use App\Modules\Event\Services\Event\EventData;
use App\Modules\Landing\Http\Requests\ContactSendRequest;
use App\Modules\Landing\Http\Resources\Blog\BlogItemResource;
use App\Modules\Landing\Http\Resources\Event\EventItemResource;
use App\Modules\Landing\Http\Resources\Lecturer\LecturerItemResource;
use App\Modules\Landing\Mail\ContactSend;
use App\Modules\Pages\Http\Resources\Client\PageMetaInfoResource;
use App\Modules\Pages\Models\Blog;
use App\Modules\Pages\Models\Page;
use App\Modules\Pages\Services\Client\BlogData;
use App\Modules\Pages\Services\Client\LecturerData;
use App\Modules\Review\Services\ReviewService;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Inertia\Response;
use Laravel\Jetstream\Jetstream;
use SeoData;
use View;

/**
 * @property MetaInterface meta
 */
class LandingPageController extends Controller
{

    /**
     * @var MetaInterface
     */
    protected $meta;

    protected array $directionArray = [];

    /**
     * LandingPageController constructor.
     *
     * @param MetaInterface $meta
     */
    public function __construct(MetaInterface $meta)
    {
        $this->meta = $meta;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function home(Request $request)
    {
        $page = Page::where('name', 'home')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];
        $offlineEvents = (new EventData)
            ->setStatuses([EventStatusOptions::STATUS_ORGANIZED])
            ->setForms([EventFormOptions::FORM_OFFLINE])
            ->getEvents();

        $onlineEvents = (new EventData)
            ->setStatuses([EventStatusOptions::STATUS_ORGANIZED])
            ->setForms([EventFormOptions::FORM_ONLINE])
            ->getEvents();


        $blogs = (new BlogData())->getBlogs();

        $lecturers = (new LecturerData())->getRandomLecturers();

        $allSeoData = SeoData::setTitle(__('seo.home.title'))
            ->setDescription(__('seo.home.description'))
            ->setKeywords(__('seo.home.description'))
            ->setOgTitle(__('seo.home.title'))
            ->setOgDescription(__('seo.home.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Landing/Home/Index', [
            'page' => $pageData,
            'onlineEvents' => $onlineEvents,
            'offlineEvents' => $offlineEvents,
            'blogs' => $blogs,
            'lecturers' => $lecturers,
            'reviews' => (new ReviewService)->getLastReviews(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function about(Request $request)
    {
        $page = Page::where('name', 'about')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];

        $allSeoData = SeoData::setTitle(__('seo.about.title'))
            ->setDescription(__('seo.about.description'))
            ->setKeywords(__('seo.about.description'))
            ->setOgTitle(__('seo.about.title'))
            ->setOgDescription(__('seo.about.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Landing/About/Index', [
            'page' => $pageData,
            'seo' => $allSeoData
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function contact(Request $request)
    {
        $page = Page::where('name', 'contact')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];

        $allSeoData = SeoData::setTitle(__('seo.contact.title'))
            ->setDescription(__('seo.contact.description'))
            ->setKeywords(__('seo.contact.description'))
            ->setOgTitle(__('seo.contact.title'))
            ->setOgDescription(__('seo.contact.description'))
            ->getSeoData();

        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Landing/Contact/Index', [
            'page' => $pageData,
            'seo' => $allSeoData
        ]);
    }


    /**
     * @param ContactSendRequest $request
     * @return RedirectResponse
     */
    public function contactSend(ContactSendRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];
        $setting = Page::where('name', 'setting')->firstOrFail();
        $data ['to'] = $setting->meta[0]['inputs'][0]['value'];
        $data ['subject'] = $setting->meta[0]['inputs'][1]['value'];

        Mail::to($data['to'])->send(new ContactSend($data));
        return redirect()->route('contact.index');
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function news(Request $request): \Inertia\Response
    {
        /** @var $blogs LengthAwarePaginator */
        $blogs = Blog::query();
        if ($request->directions) {
            $directions = $request->directions;
            foreach ($directions as $direction) {
                $blogs->whereHas('directions', function ($query) use ($direction) {
                    $query->where('direction_id', $direction);
                });
            }
        }

        $directions = (new DirectionListResource())->getAndSetCrudResources(0, true, true)->toArray();
        $this->parseTree($directions);

        $blogs = $blogs->with([
            'translations',
            'images'
        ])->active()->orderBy('created_at','desc')->paginate($request->get('total', 9));



        $blogsData = collect();
        foreach ($blogs->getIterator() as $blog) {
            $blogsData->push((new BlogItemResource($blog))->toListItem());
        }
        $blogs->setCollection($blogsData);

        $allSeoData = (new BlogItemResource())->toListSeoData();
        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Landing/News/Index', [
            'items' => $blogs,
            'seo' => $allSeoData,
            'route' => route('news.index'),
            'directions' => (new DirectionListResource())->getAndSetCrudResources(0, true, true)->toArray(),
            'selectedDirections' => $request->directions ?? [],
        ]);
    }

    /**
     * @param Request $request
     * @param $slug
     *
     * @return Response
     */
    public function newsView(Request $request, $slug): \Inertia\Response
    {
        $blog = Blog::with([
            'translations',
            'images'
        ])
            ->active()
            ->where('id', getIdFromSlug($slug))->firstOrFail();


        $allSeoData = (new BlogItemResource($blog))->toSeoData();
        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Landing/News/Show', [
            'item' => (new BlogItemResource($blog))->toArrayForShow(),
            'seo' => $allSeoData
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function trainers(Request $request): \Inertia\Response
    {
        /** @var $lecturers LengthAwarePaginator */
        $lecturers = Lecturer::with([
            'translations',
            'images'
        ])->active()->paginate($request->get('total', 9));

        $lecturerData = collect();
        foreach ($lecturers->getIterator() as $lecturer) {
            $lecturerData->push((new LecturerItemResource($lecturer))->toListItem());
        }
        $lecturers->setCollection($lecturerData);

        $allSeoData = (new LecturerItemResource())->toListSeoData();
        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        return Jetstream::inertia()->render($request, 'Landing/Trainers/Index', [
            'items' => $lecturers,
            'seo' => $allSeoData
        ]);
    }


    /**
     * @param Request $request
     * @param $slug
     *
     * @return JsonResponse
     */
    public function trainersShow(Request $request, $slug)
    {
        $lecturer = Lecturer::with([
            'translations',
            'images'
        ])
            ->active()
            ->where('id', getIdFromSlug($slug))
            ->firstOrFail();


        return response()->json([
            'lecturer' => (new LecturerItemResource($lecturer))->toArrayForShow()
        ]);
    }


    /**
     * @param array $array
     * @param int $level
     */
    public function parseTree(array $array, int $level = 1)
    {
        foreach($array as $key => $item){
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
            if(count($item['children'])){
                $this->parseTree($item['children'], $level + 1);
            }
        }
    }
}
