<?php
/**
 *  app\Modules\Landing\Http\Resources\Team\TeamItemResource.php
 *
 * Date-Time: 9/19/2021
 * Time: 5:15 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
namespace App\Modules\Landing\Http\Resources\Team;


use App\Modules\Pages\Models\Team;
use SeoData;
use Str;

/**
 * @property Team item
 */
class TeamItemResource
{

    /**
     * @var Team
     */
    protected $item;

    /**
     * BlogItemResource constructor.
     *
     * @param Team|null $team
     */
    public function __construct(Team $team = null)
    {
        $this->item = $team;
    }

    /**
     * @return array
     */
    public function toListItem(): array
    {
        return [
            'id'    => $this->item->id,
            'name' => $this->item->name,
            'about' => Str::limit($this->item->about, 112),
            'position' => Str::limit($this->item->position, 112),
            'profile_image' => $this->item->getImageByKey('profile'),
            'show_url'  =>route('team.show',generateSlug($this->item->id,$this->item->name)),
        ];
    }

    /**
     * @return array
     */
    public function toArrayForShow(): array
    {
        return [
            'id'    => $this->item->id,
            'name' => $this->item->name,
            'position' => $this->item->position,
            'about' => $this->item->about,
            'profile_image' => $this->item->getImageByKey('profile'),
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
        return SeoData::setTitle(__('seo.team.title'))
            ->setDescription( __('seo.team.description'))
            ->setKeywords( __('seo.team.description'))
            ->setOgTitle( __('seo.team.title'))
            ->setOgDescription( __('seo.team.description'))
            ->getSeoData();
    }

}
