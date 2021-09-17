<?php
/**
 *  app/Modules/Customer/Services/Customer/CustomerCompanyEmployee.php
 *
 * Date-Time: 30.07.21
 * Time: 14:27
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
namespace App\Modules\Customer\Services\Customer;

use App\Models\User;


class CustomerCompanyEmployee
{
    private $users;

    protected array $userIds;

    public function __construct(array $userIds = [])
    {
        $this->userIds = $userIds;
    }

    /**
     * @return $this
     */
    public function setUsers(): CustomerCompanyEmployee
    {
        $this->users = User::whereIn('id', $this->userIds)->with('ownCompanies.company')->whereHas('ownCompanies')->get();
        return $this;
    }

    /**
     * This method return every unique ids which are connected to users
     *
     * @return array
     */
    public function getCompanyEmployeeIdsByUsers(): array
    {
        if (!count($this->users)) {
            return [];
        }

        $dataIds = [];

        foreach ($this->users as $user) {
            if ($user->companies) {
                foreach ($user->companies as $company) {
                    $dataIds = [...$dataIds, ...$company->employees->pluck('id')->toArray()];
                }
            }
        }
        return array_unique($dataIds);
    }
}
