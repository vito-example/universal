<?php
/**
 *  app\Modules\Landing\Http\Resources\Service\ServiceItemResource.php
 *
 * Date-Time: 9/21/2021
 * Time: 5:46 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Landing\Http\Resources\Service;


use App\Modules\Pages\Models\Project;
use App\Modules\Pages\Models\Service;
use SeoData;
use Str;

/**
 * @property Service item
 */
class ServiceItemResource
{

    /**
     * @var Service
     */
    protected $item;

    /**
     * BlogItemResource constructor.
     *
     * @param Service|null $service
     */
    public function __construct(Service $service = null)
    {
        $this->item = $service;
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
            'show_url'  =>route('service.show',generateSlug($this->item->id,$this->item->title)),
            'created_at' => $this->getDateFormat(),
        ];
    }

    /**
     * @return array
     */
    public function toStatic(): array
    {
        return [
            'id'    => $this->item->id,
            'title' => $this->item->title,
            'description' => Str::limit($this->item->description, 70),
            'profile_image' => $this->item->getImageByKey('profile'),
            'slug'  =>generateSlug($this->item->id,$this->item->title),
            'created_at' => $this->getDateFormat(),
        ];
    }

    /**
     * @return array
     */
    public function toArrayForShow(): array
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
        return SeoData::setTitle(__('seo.project.title'))
            ->setDescription( __('seo.project.description'))
            ->setKeywords( __('seo.project.description'))
            ->setOgTitle( __('seo.project.title'))
            ->setOgDescription( __('seo.project.description'))
            ->getSeoData();
    }

}
