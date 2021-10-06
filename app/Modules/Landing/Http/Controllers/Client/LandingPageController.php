<?php

namespace App\Modules\Landing\Http\Controllers\Client;

use App\Modules\Landing\Http\Requests\ContactSendRequest;
use App\Modules\Landing\Http\Resources\Blog\BlogItemResource;
use App\Modules\Landing\Http\Resources\Project\ProjectItemResource;
use App\Modules\Landing\Http\Resources\Service\ServiceItemResource;
use App\Modules\Landing\Http\Resources\Team\TeamItemResource;
use App\Modules\Landing\Mail\ContactSend;
use App\Modules\Pages\Http\Resources\Client\PageMetaInfoResource;
use App\Modules\Pages\Models\Blog;
use App\Modules\Pages\Models\Page;
use App\Modules\Pages\Models\Project;
use App\Modules\Pages\Models\Service;
use App\Modules\Pages\Models\Team;
use App\Modules\Pages\Services\Client\BlogData;
use App\Modules\Pages\Services\Client\ProjectData;
use App\Modules\Pages\Services\Client\ServiceData;
use App\Modules\Pages\Services\Client\TeamData;
use Butschster\Head\Contracts\MetaTags\MetaInterface;
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
    public function home(Request $request): Response
    {
        $page = Page::where('name', 'home')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];

        $blogs = (new BlogData())->getBlogs();

        $projects = (new ProjectData())->getProjects();

        $services = (new ServiceData())->getServices();

        $teams = (new TeamData())->getTeams();

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
            'blogs' => $blogs,
            'projects' => $projects,
            'teams' => $teams,
            'services' => $services
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function about(Request $request): Response
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
     * @return Response
     */
    public function blog(Request $request): \Inertia\Response
    {
        /** @var $blogs LengthAwarePaginator */
        $blogs = Blog::query();

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

        $page = Page::where('name', 'blog')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];

        return Jetstream::inertia()->render($request, 'Landing/News/Index', [
            'items' => $blogs,
            'seo' => $allSeoData,
            'route' => route('blog.index'),
            'page' => $pageData
        ]);
    }

    /**
     * @param Request $request
     * @param $slug
     *
     * @return Response
     */
    public function blogView(Request $request, $slug): \Inertia\Response
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

        $page = Page::where('name', 'blog')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];

        return Jetstream::inertia()->render($request, 'Landing/News/Show', [
            'item' => (new BlogItemResource($blog))->toArrayForShow(),
            'seo' => $allSeoData,
            'page' => $pageData
        ]);
    }


    /**
     * @param Request $request
     *
     * @return Response
     */
    public function project(Request $request): \Inertia\Response
    {
        /** @var $projects LengthAwarePaginator */
        $projects = Project::query();

        $projects = $projects->with([
            'translations',
            'images'
        ])->active()->orderBy('created_at','desc')->paginate($request->get('total', 9));



        $projectsData = collect();
        foreach ($projects->getIterator() as $project) {
            $projectsData->push((new ProjectItemResource($project))->toListItem());
        }
        $projects->setCollection($projectsData);

        $allSeoData = (new ProjectItemResource())->toListSeoData();
        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        $page = Page::where('name', 'project')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];

        return Jetstream::inertia()->render($request, 'Landing/Project/Index', [
            'items' => $projects,
            'seo' => $allSeoData,
            'route' => route('blog.index'),
            'page' => $pageData
        ]);
    }

    /**
     * @param Request $request
     * @param $slug
     *
     * @return Response
     */
    public function projectView(Request $request, $slug): \Inertia\Response
    {
        $project = Project::with([
            'translations',
            'images'
        ])
            ->active()
            ->where('id', getIdFromSlug($slug))->firstOrFail();


        $allSeoData = (new ProjectItemResource($project))->toSeoData();
        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        $page = Page::where('name', 'project')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];

        return Jetstream::inertia()->render($request, 'Landing/Project/Show', [
            'item' => (new ProjectItemResource($project))->toArrayForShow(),
            'seo' => $allSeoData,
            'page' => $pageData
        ]);
    }

    public function service(Request $request): \Inertia\Response
    {
        /** @var $services LengthAwarePaginator */
        $services = Service::query();

        $services = $services->with([
            'translations',
            'images'
        ])->active()->orderBy('created_at','desc')->paginate($request->get('total', 12));



        $servicesData = collect();
        foreach ($services->getIterator() as $service) {
            $servicesData->push((new ServiceItemResource($service))->toListItem());
        }
        $services->setCollection($servicesData);

        $allSeoData = (new ProjectItemResource())->toListSeoData();
        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        $page = Page::where('name', 'service')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];

        return Jetstream::inertia()->render($request, 'Landing/Service/Index', [
            'items' => $services,
            'seo' => $allSeoData,
            'route' => route('blog.index'),
            'page' => $pageData
        ]);
    }

    /**
     * @param Request $request
     * @param $slug
     *
     * @return Response
     */
    public function serviceView(Request $request, $slug): \Inertia\Response
    {
        $service = Service::with([
            'translations',
            'images'
        ])
            ->active()
            ->where('id', getIdFromSlug($slug))->firstOrFail();


        $allSeoData = (new ServiceItemResource($service))->toSeoData();
        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        $page = Page::where('name', 'service')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];

        return Jetstream::inertia()->render($request, 'Landing/Service/Show', [
            'item' => (new ServiceItemResource($service))->toArrayForShow(),
            'seo' => $allSeoData,
            'page' => $pageData
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function team(Request $request): \Inertia\Response
    {
        /** @var $teams LengthAwarePaginator */
        $teams = Team::query();

        $teams = $teams->with([
            'translations',
            'images'
        ])->active()->orderBy('created_at','desc')->paginate(45);

        $teamsData = collect();
        foreach ($teams->getIterator() as $team) {
            $teamsData->push((new TeamItemResource($team))->toListItem());
        }
        $teams->setCollection($teamsData);

        $allSeoData = (new TeamItemResource())->toListSeoData();
        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        $page = Page::where('name', 'team')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];

        return Jetstream::inertia()->render($request, 'Landing/Team/Index', [
            'items' => $teamsData,
            'seo' => $allSeoData,
            'route' => route('team.index'),
            'page' => $pageData
        ]);
    }

    /**
     * @param Request $request
     * @param $slug
     *
     * @return Response
     */
    public function teamView(Request $request, $slug): \Inertia\Response
    {
        $team = Team::with([
            'translations',
            'images'
        ])
            ->active()
            ->where('id', getIdFromSlug($slug))->firstOrFail();


        $allSeoData = (new TeamItemResource($team))->toSeoData();
        View::composer('app', function ($view) use ($allSeoData) {
            $view->with('allSeoData', $allSeoData);
        });

        $page = Page::where('name', 'team')->first();
        $pageData = $page ? (new PageMetaInfoResource($page->meta))->toArray($request) : [];

        return Jetstream::inertia()->render($request, 'Landing/Team/Show', [
            'item' => (new TeamItemResource($team))->toArrayForShow(),
            'seo' => $allSeoData,
            'page' => $pageData
        ]);
    }
}
