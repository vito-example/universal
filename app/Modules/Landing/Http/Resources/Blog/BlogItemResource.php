<?php


namespace App\Modules\Landing\Http\Resources\Blog;


use App\Modules\Pages\Models\Blog;
use SeoData;
use Str;

/**
 * @property Blog item
 */
class BlogItemResource
{

    /**
     * @var Blog
     */
    protected $item;

    /**
     * BlogItemResource constructor.
     *
     * @param Blog|null $blog
     */
    public function __construct(Blog $blog = null)
    {
        $this->item = $blog;
    }

    /**
     * @return array
     */
    public function toListItem(): array
    {
        return [
            'id'    => $this->item->id,
            'title' => $this->item->title,
            'description' => $this->item->short_description,
            'profile_image' => $this->item->getImageByKey('profile'),
            'show_url'  =>route('blog.show',generateSlug($this->item->id,$this->item->title)),
            'created_at' => $this->getDateFormat(),
        ];
    }

    /**
     * @return array
     */
    public function toArrayForShow()
    {
        return [
            'id'    => $this->item->id,
            'title' => $this->item->title,
            'description' => $this->item->description,
            'profile_image' => $this->item->getImageByKey('profile'),
            'gallery' => $this->item->galleries_meta,
            'created_at' => $this->getDateFormat(),
        ];
    }

    /**
     * @return string
     */
    private function getDateFormat()
    {
        if (!$this->item->date) {
            return '';
        }
        return $this->item->date->format('Y') . ' '  . __('date.month.' . $this->item->date->format('M')) . ' ' . $this->item->date->format('d');
    }

    /**
     * @return array
     */
    public function toSeoData()
    {
        $item = $this->item;
        $description = $this->item->seo_meta['description'] ?? $this->item->description;
        $title = $this->item->seo_meta['title'] ?? $this->item->title;
        $keyword = $this->item->seo_meta['keyword'] ?? $this->item->description;
        return SeoData::setTitle($title)
            ->setDescription($description)
            ->setKeywords($keyword)
            ->setOgTitle($title)
            ->setOgDescription($description)
            ->setOgImage($this->item->getImageByKey('profile'))->getSeoData();
    }

    /**
     * @return array
     */
    public function toListSeoData(): array
    {
        return SeoData::setTitle(__('seo.blog.title'))
            ->setDescription( __('seo.blog.description'))
            ->setKeywords( __('seo.blog.description'))
            ->setOgTitle( __('seo.blog.title'))
            ->setOgDescription( __('seo.blog.description'))
            ->getSeoData();
    }

}
