<?php


namespace App\Modules\Customer\Exports;


use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * @property array|null filterData
 */
class ExportCustomers implements FromCollection, WithHeadings, WithMapping
{

    /**
     * @var array|null
     */
    protected $filterData;

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
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::with([
        ])->filter($this->filterData)->get();
    }

    /**
     * @param User $user
     *
     * @return ExportCustomers[]
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->surname,
            $user->phone_number,
            $user->email,
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'surname',
            'phone_number' ,
            'name' ,
        ];
    }

}
