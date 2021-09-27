<?php


namespace App\Modules\Pages\Services\Client;


use App\Modules\Pages\Http\Resources\Client\PageMetaInfoResource;
use App\Modules\Pages\Models\Page;

/**
 * @property string|null path
 * @property string pageType
 */
class PageSeoService
{

    const NAME_HEADER_SCRIPTS = 'analytic';

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var string
     */
    protected $pageType = 'home';

    /**
     * @param string|null $path
     *
     * @return $this
     */
    public function setPath(string $path = null)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @param string|null $pageType
     *
     * @return $this
     */
    public function setPageType(string $pageType = null)
    {
        $this->pageType = $pageType ?: 'home';
        return $this;
    }

    /**
     * @return $this
     */
    public function parsePathAndSetPageType()
    {
        if (empty($this->path)) {
            $this->pageType = 'home';
            return $this;
        }
        $segments = explode('/', $this->path);

        if (empty($segments[1])) {
            $pageName = 'home';
        } else {
            $pageName = $segments[1];
        }
        $this->pageType = $pageName;

        return $this;
    }

    /**
     * @return $this
     */
    public function parsePathAndSetLocale()
    {
        if (empty($this->path)) {
            app()->setLocale(config('app.locale'));
            return $this;
        }
        $segments = explode('/', $this->path);

        if (in_array($segments[0], config('language_manager.locales'))) {
            app()->setLocale($segments[0]);
            return $this;
        }

        app()->setLocale(config('app.locale'));

        return $this;
    }

    /**
     * @return array
     */
    public function getPageData()
    {
        $seoPages = $this->getSeoPageResource();
        if (empty($seoPages)) {
            return [];
        }

        $pageData = $this->parseAndGetSeoData(collect($seoPages)->where('key', 'default')->first());
        $pageData = array_merge($pageData, $this->getAnalyticData($seoPages));

        return $pageData;
    }

    /**
     * @param array $seoPages
     *
     * @return array
     */
    public function getAnalyticData(array $seoPages = [])
    {
        $analyticData = collect($seoPages)->where('key', self::NAME_HEADER_SCRIPTS)->first();

        if (empty($analyticData)) {
            return [
                'scripts' => '',
                'no_scripts' => '',
            ];
        }

        if (!empty($analyticData['fields'])) {
            return [
                'scripts' => isset($analyticData['fields']['analytic_scripts']) ? $analyticData['fields']['analytic_scripts']['value'] : '',
                'no_scripts' => isset($analyticData['fields']['analytic_no_scripts']) ? $analyticData['fields']['analytic_no_scripts']['value'] : '',
            ];
        } else {
            return [
                'scripts' => isset($analyticData['inputs'][0]) ? $analyticData['inputs'][0]['value'] : '',
                'no_scripts' => isset($analyticData['inputs'][1]) ? $analyticData['inputs'][1]['value'] : '',
            ];
        }
    }

    /**
     * @param array $seoMeta
     *
     * @return array
     */
    private function parseAndGetSeoData($seoMeta = [])
    {
        if (empty($seoMeta)) {
            return [];
        }
        $fields = $seoMeta['fields'];

        return [
            'page' => $this->pageType,
            'title' => $fields['seo_title']['value'],
            'description' => $fields['seo_description']['value'],
            'keywords' => $fields['seo_keywords']['value'],
            'og_title' => $fields['seo_og_title']['value'],
            'og_description' => $fields['seo_og_description']['value'],
            'image' => $fields['seo_og_image']['value'],
            'locale' => app()->getLocale(),
        ];
    }

    /**
     * @return Page|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    private function getSeoPages()
    {
        return Page::whereName(Page::NAME_SEO)->first();
    }

    /**
     * @return array
     */
    private function getSeoPageResource()
    {
        $page = $this->getSeoPages();
        return $page ? (new PageMetaInfoResource($page->meta))->toArray() : [];
    }

}
