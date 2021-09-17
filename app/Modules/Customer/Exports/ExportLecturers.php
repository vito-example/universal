<?php
/**
 *  app/Modules/Customer/Exports/ExportLecturers.php
 *
 * Date-Time: 12.08.21
 * Time: 09:51
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Customer\Exports;


use App\Modules\Customer\Models\Lecturer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * @property array|null filterData
 */
class ExportLecturers implements FromCollection, WithHeadings, WithMapping
{

    /**
     * @var array|null
     */
    protected ?array $filterData;

    /**
     * ExportCustomers constructor.
     *
     * @param array|null $filterData
     */
    public function __construct(array $filterData = null)
    {
        $this->filterData = $filterData;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return Lecturer::with([

        ])->filter($this->filterData)->get();
    }

    /**
     * @param Lecturer $lecturer
     *
     * @return ExportLecturers[]
     */
    public function map($lecturer): array
    {
        return [
            $lecturer->id,
            $lecturer->full_name,
            $lecturer->description,
            $lecturer->status ? 'active' : 'disabled',
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'description',
            'status' ,
        ];
    }

}
