<?php


namespace App\Modules\Company\Exports;


use App\Models\User;
use App\Modules\Company\Models\CompanyEmployee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * @property array|null filterData
 */
class ExportCompanyEmployee implements FromCollection, WithHeadings, WithMapping
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
        return CompanyEmployee::with([
            'company'
        ])->filter($this->filterData)->get();
    }

    /**
     * @param CompanyEmployee $companyEmployee
     *
     * @return ExportCompanyEmployee[]
     */
    public function map($companyEmployee): array
    {
        return [
            $companyEmployee->id,
            $companyEmployee->company->title,
            $companyEmployee->name,
            $companyEmployee->email,
            $companyEmployee->phone,
            $companyEmployee->role,
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'company',
            'name',
            'email' ,
            'phone' ,
            'role' ,
        ];
    }

}
