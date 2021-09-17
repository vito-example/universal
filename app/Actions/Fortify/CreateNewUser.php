<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyActivity;
use App\Modules\Company\Models\CompanyMember;
use App\Modules\Company\Models\Translations\CompanyActivityTranslation;
use App\Modules\Customer\Models\Activity;
use App\Modules\Customer\Models\Translations\ActivityTranslation;
use Arr;
use DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Log;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * @param array $input
     *
     * @return User|\Illuminate\Database\Eloquent\Model|mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(array $input)
    {
        try {
            DB::beginTransaction();
            $user =  User::create([
                'name' => $input['name'],
                'surname'=> $input['surname'],
                'phone_number' => $input['phone_number'],
                'terms' => $input['terms'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
            $user->status= User::STATUS_ACTIVE;
            $user->save();

            if (!empty($input['legal_person'])) {
                $company = Company::create([
                    'title' => $input['company'][0]['title'],
                    'identify_id' => $input['company'][0]['identify_id'],
                    'address' => $input['company'][0]['address'],
                    'description' => $input['company'][0]['description']
                ]);

                $company->ownerMembers()->updateOrCreate([
                    'user_id' => $user->id,
                    'company_id' => $company->id,
                    'role' => CompanyMember::ROLE_OWNER
                ]);
                $company->save();
                if (count($input['company_employee'])) {
                    $company->employees()->createMany($input['company_employee']);
                }
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('[Error Create User]',[
                'inputs'    => Arr::only($input,['password','password_confirmation']),
                'error' => $ex
            ]);
            throw new \Exception(__('Error Register User'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $user;
    }
}
