<?php


namespace App\Modules\Landing\Http\Resources\Lecturer;


use App\Modules\Customer\Models\Lecturer;
use SeoData;
use Str;

/**
 * @property Lecturer item
 */
class LecturerItemResource
{

    /**
     * @var Lecturer|null
     */
    protected ?Lecturer $item;

    /**
     * BlogItemResource constructor.
     *
     * @param Lecturer|null $lecturer
     */
    public function __construct(Lecturer $lecturer = null)
    {
        $this->item = $lecturer;
    }

    /**
     * @return array
     */
    public function toListItem(): array
    {
        return [
            'id'    => $this->item->id,
            'full_name' => $this->item->full_name,
            'description' =>  Str::limit($this->item->description, 124),
            'profile_image' => $this->item->getImageByKey('profile'),
            'show_url'  =>route('trainers.show',generateSlug($this->item->id,$this->item->full_name)),
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
            'full_name' => $this->item->full_name,
            'description' => $this->item->description,
            'profile_image' => $this->item->getImageByKey('profile'),
            'created_at' => $this->getDateFormat(),
        ];
    }

    /**
     * @return string
     */
    private function getDateFormat(): string
    {
        if (!$this->item->date) {
            return '';
        }
        return $this->item->date->format('Y') . ' '  . __('date.month.' . $this->item->date->format('M')) . ' ' . $this->item->date->format('d');
    }

    /**
     * @return array
     */
    public function toSeoData(): array
    {
        $item = $this->item;
        $description = \Illuminate\Support\Str::words(strip_tags($item->description), 50,'....');
        return SeoData::setTitle($item->full_name)
            ->setDescription($description)
            ->setKeywords($description)
            ->setOgTitle($item->full_name)
            ->setOgDescription($description)
            ->setOgImage($this->item->getImageByKey('profile'))->getSeoData();
    }

    /**
     * @return array
     */
    public function toListSeoData(): array
    {
        return SeoData::setTitle(__('seo.lecturer.title'))
            ->setDescription( __('seo.lecturer.description'))
            ->setKeywords( __('seo.lecturer.description'))
            ->setOgTitle( __('seo.lecturer.title'))
            ->setOgDescription( __('seo.lecturer.description'))
            ->getSeoData();
    }

}
