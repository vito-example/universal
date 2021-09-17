<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyActivity;
use App\Modules\Company\Models\CompanyMember;
use App\Modules\Customer\Models\Activity;
use Illuminate\Database\Seeder;

class CompanyFakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::inRandomOrder()->take(150)->get();
        $companyActivities = CompanyActivity::inRandomOrder()->take(150)->get();
        Company::factory(200)->create()->each(function(Company $company) use($users,$companyActivities){
            $company->activities()->sync($companyActivities->take(mt_rand(1,10))->pluck('id')->toArray());
            $company->ownerMembers()->updateOrCreate([
                'user_id' => $users->random(1)->first()->id,
                'company_id' => $company->id,
                'role' => CompanyMember::ROLE_OWNER
            ]);
            $company->save();
        });
    }
}
