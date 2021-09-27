<?php


namespace App\Modules\Pages\Services\Client;

use App\Modules\Pages\Models\Page;
use PageSeoService;

/**
 * @property string|null title
 * @property string|null description
 * @property string|null keywords
 * @property string|null ogTitle
 * @property string|null ogDescription
 * @property string|null ogImage
 * @property string locale
 */
class SeoData
{

    /**
     * @var
     */
    protected $title;

    /**
     * @var
     */
    protected $description;

    /**
     * @var
     */
    protected $keywords;

    /**
     * @var
     */
    protected $ogTitle;

    /**
     * @var
     */
    protected $ogDescription;

    /**
     * @var
     */
    protected $ogImage;

    /**
     * @var
     */
    protected $locale;

    /**
     * @param string|null $title
     *
     * @return $this
     */
    public function setTitle(string $title = null)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription(string $description = null)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string|null $keywords
     *
     * @return $this
     */
    public function setKeywords(string $keywords = null)
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @param string|null $ogTitle
     *
     * @return $this
     */
    public function setOgTitle(string $ogTitle = null)
    {
        $this->ogTitle = $ogTitle;
        return $this;
    }

    /**
     * @param string|null $ogDescription
     *
     * @return $this
     */
    public function setOgDescription(string $ogDescription = null)
    {
        $this->ogDescription = $ogDescription;
        return $this;
    }

    /**
     * @param string|null $ogImage
     *
     * @return $this
     */
    public function setOgImage(string $ogImage = null)
    {
        $this->ogImage = $ogImage;
        return $this;
    }

    /**
     * @param string|null $locale
     *
     * @return $this
     */
    public function setLocale(string $locale = null)
    {
        $this->locale = !empty($locale) ? $locale : app()->getLocale();
        return $this;
    }

    /**
     * @return array
     */
    public function getSeoData()
    {
        $analyticSeoData = Page::whereName(Page::NAME_SEO)->first();
        $analytics = PageSeoService::getAnalyticData($analyticSeoData ? $analyticSeoData->meta : []);

        return [
            'scripts' => $analytics['scripts'],
            'no_scripts' => $analytics['no_scripts'],
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'og_title' => $this->ogTitle,
            'og_description' => $this->ogDescription,
            'image' => $this->ogImage,
            'locale' => $this->locale ? $this->locale : app()->getLocale(),
        ];
    }

}
