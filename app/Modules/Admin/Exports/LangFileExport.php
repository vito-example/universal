<?php


namespace App\Modules\Admin\Exports;


use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * @property Collection langFiles
 */
class LangFileExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @var
     */
    protected $langFiles;

    /**
     * LangFileExport constructor.
     *
     * @param $langFiles
     */
    public function __construct($langFiles)
    {
        $this->langFiles = $langFiles;
    }

    /**
     * @return Collection|\Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->langFiles;
    }

    /**
     * @param $langFile
     *
     * @return array
     */
    public function map($langFile): array
    {
        return [
            $langFile->locale,
            $langFile->group,
            $langFile->key,
            $langFile->value
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'locale',
            'group',
            'key',
            'value'
        ];
    }

}
