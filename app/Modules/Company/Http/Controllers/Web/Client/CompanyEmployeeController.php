<?php
/**
 *  app/Modules/Company/Http/Controllers/Web/Client/CompanyEmployeeController.php
 *
 * Date-Time: 26.08.21
 * Time: 08:55
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */

namespace App\Modules\Company\Http\Controllers\Web\Client;


use App\Http\Controllers\Controller;
use App\Modules\Company\Models\CompanyEmployee;
use App\Modules\Customer\Http\Requests\Client\CompanyEmployeeStoreRequest;
use Illuminate\Http\RedirectResponse;

class CompanyEmployeeController extends Controller
{
    /**
     * @param CompanyEmployeeStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function companyEmployeeStore(CompanyEmployeeStoreRequest $request): RedirectResponse
    {
        $companyEmployee = null;
        if ($request->get('id')) {
            $companyEmployee = CompanyEmployee::where('id', $request->get('id'))->firstOrFail();
        }
        $createData = [
            'company_id' => $request->get('company_id'),
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => $request->get('role'),
            'phone' => $request->get('phone'),
        ];
        if ($companyEmployee) {
            $companyEmployee->update($createData);
        } else {
            $companyEmployee = CompanyEmployee::create($createData);
        }

        return redirect()->route('profile.show',['tab' => 'colleagues']);
    }


    public function companyEmployeeDestroy(int $id){
        try {
            $companyEmployee = CompanyEmployee::findOrFail($id);
            $companyEmployee->delete();
        } catch (\Exception $ex) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'validation_error' => [__('მონაცემის წაშლა ვერ მოხერხდა')],
            ]);
            throw $error;
        }
        return redirect()->route('profile.show',['tab' => 'colleagues']);
    }

}
