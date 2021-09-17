<?php


namespace App\Modules\Company\Services\Company;


use App\Modules\Base\Models\Image;
use App\Modules\Company\Http\Resources\Company\EditResource;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyMember;
use Arr;

/**
 * @property array companyInfo
 * @property array|null employees
 */
class CompanyStore
{

    /**
     * @var
     */
    protected $company;

    /**
     * @var
     */
    protected $companyInfo;

    /**
     * @var array|null
     */
    protected ?array $employees;

    /**
     * @return EditResource
     */
    public function getCompanyResource()
    {
        return new EditResource($this->company);
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param null $companyId
     *
     * @return $this
     */
    public function setCompanyById($companyId = null)
    {
        $this->company = Company::find($companyId);
        return $this;
    }

    /**
     * @param array $companyInfo
     *
     * @return $this
     */
    public function setInfoData(array $companyInfo = [])
    {
        $this->companyInfo = $companyInfo;
        return $this;
    }

    /**
     * @param array $employees
     *
     * @return $this
     */
    public function setEmployees(array $employees = []): CompanyStore
    {
        $this->employees = $employees;
        return $this;
    }

    /**
     * @return $this
     */
    public function store()
    {
        $this->createCompany();
        $this->saveImages();
        return $this;
    }

    /**
     * @return void
     */
    private function saveImages()
    {
        if (empty($this->companyInfo['images'])) {
            return;
        }
        $images = !empty($this->companyInfo['images']) ? $this->companyInfo['images'] : [];
        $itemImages = $this->company->images;

        foreach ($images as $key => $image) {
            $imageModel = Image::findOrFail($image['item']['id']);
            $imageModel->imageable()->associate($this->company);
            $imageModel->save();
            $itemImages = $itemImages->reject(function ($img) use ($imageModel) {
                return $img->id === $imageModel->id;
            });
        }

        $itemImages->map(function ($modelImage) {
            $modelImage->delete();
        });
    }

    /**
     * @return void
     */
    private function createCompany()
    {
        $saveData = Arr::except($this->companyInfo, ['images', 'owners']);
        if ($this->company) {
            $this->company->update($saveData);
        } else {
            $this->company = Company::create($saveData);
        }

        $this->company->save();



        // delete old employees
        $employeeIds = array_column($this->employees,'id');

        $this->company->employees()->whereNotIn('id',$employeeIds)->delete();

        // Save/Update employees
        foreach ($this->employees as $employee) {
            $employeeId = $employee['id'] ?? null;
            if (!$employeeId) {
                $this->company->employees()->create($employee);
                continue;
            }
            unset($employee['id']);
            $this->company->employee($employeeId)->update($employee);
        }



        if (empty($this->companyInfo['owners'])) {
            $this->company->ownerMembers()->forceDelete();
        } else {
            collect($this->companyInfo['owners'])->map(function ($ownerId) {
                $this->company->ownerMembers()->updateOrCreate([
                    'user_id' => $ownerId,
                    'company_id' => $this->company->id,
                    'role' => CompanyMember::ROLE_OWNER
                ]);
            });
        }

    }

}
