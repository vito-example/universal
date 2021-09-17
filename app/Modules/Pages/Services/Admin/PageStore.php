<?php


namespace App\Modules\Pages\Services\Admin;


use App\Modules\Pages\Models\Page;
use Arr;

/**
 * @property array baseData
 * @property string name
 * @property Page|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null page
 */
class PageStore
{
    /**
     * @var
     */
    protected $baseData = [];

    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $page;

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name = '')
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param array $baseData
     *
     * @return $this
     */
    public function setBaseData(array $baseData = []) : self
    {
        $this->baseData = $baseData;
        return $this;
    }

    /**
     * @return $this
     */
    public function save() : self
    {
        $page = Page::where('name', $this->name)->first();
        $saveData = $this->baseData['meta'];
        $meta = $saveData;

        if ($page) {
            $page->update([
                'meta'  => $meta
            ]);
        } else {
            $page = Page::create([
                'name'      => $this->name,
                'meta'      => $meta
            ]);
        }

        $this->page = $page;

        return $this;
    }

}
