<?php


namespace App\Modules\Company\Http\Controllers\Web\Client;


use App\Http\Controllers\Controller;
use App\Modules\Company\Http\Resources\Company\CompanyItemResource;
use App\Modules\Company\Http\Resources\CompanyActivity\CompanyActivityListResource;
use App\Modules\Company\Models\Company;
use App\Modules\Company\Models\CompanyActivity;
use App\Modules\Company\Models\CompanyMember;
use App\Modules\Company\Models\Translations\CompanyActivityTranslation;
use App\Modules\Customer\Http\Requests\Client\CompanyStoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use SeoData;
use Storage;
use UploadImage;

class CompanyController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function companies(Request $request)
    {
        $companies = Company::whereHas('ownerMembers', function ($builder) {
            $builder->where('user_id', auth()->id());
        })->get();
        return Jetstream::inertia()->render($request, 'Company/Index', [
            'companies' => $companies->map(function (Company $company) {
                return (new CompanyItemResource($company))->toListItem();
            }),
            'options' => [
                'company_activities' => (new CompanyActivityListResource())->getAndSetAllResources()->toArray(),
            ],
            'seo' => SeoData::setTitle(__('seo.company.title'))
                ->setDescription(__('seo.company.description'))
                ->setKeywords(__('seo.company.keywords'))
                ->setOgTitle(__('seo.company.title'))
                ->setOgDescription(__('seo.company.description'))->getSeoData()
        ]);
    }

    /**
     * @param Request $request
     * @param $slug
     *
     * @return \Inertia\Response
     */
    public function companyEdit(Request $request, $slug)
    {
        $company = Company::where('id', getIdFromSlug($slug))->whereHas('ownerMembers', function ($builder) {
            $builder->where('user_id', auth()->id())->where('role', CompanyMember::ROLE_OWNER);
        })->firstOrFail();
        return Jetstream::inertia()->render($request, 'Company/Edit', [
            'company' => (new CompanyItemResource($company))->toEditItem(),
            'options' => [
                'company_activities' => (new CompanyActivityListResource())->getAndSetAllResources()->toArray(),
            ],
            'seo' => SeoData::setTitle($company->title . ' ' . __('seo.company.title'))
                ->setDescription($company->description .' ' . __('seo.company.description'))
                ->setKeywords($company->description .' ' .__('seo.company.keywords'))
                ->setOgTitle($company->title .' ' .__('seo.company.title'))
                ->setOgImage($company->getImageByKey('profile'))
                ->setOgDescription($company->description . ' ' .__('seo.company.description'))->getSeoData()
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function companyCreate(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Company/Create', [
            'options' => [
                'company_activities' => (new CompanyActivityListResource())->getAndSetAllResources()->toArray(),
            ],
            'seo' => SeoData::setTitle(__('seo.company.title'))
                ->setDescription(__('seo.company.description'))
                ->setKeywords(__('seo.company.keywords'))
                ->setOgTitle(__('seo.company.title'))
                ->setOgDescription(__('seo.company.description'))->getSeoData()
        ]);
    }

    /**
     * @param CompanyStoreRequest $request
     *
     * @return RedirectResponse
     */
    public function companyStore(CompanyStoreRequest $request): RedirectResponse
    {
        $company = null;
        if ($request->get('id')) {
            $company = Company::where('id', $request->get('id'))->whereHas('ownerMembers', function ($builder) {
                $builder->where('user_id', auth()->id())->where('role', CompanyMember::ROLE_OWNER);
            })->firstOrFail();
        }
        $createData = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'identify_id' => $request->get('identify_id'),
            'address' => $request->get('address'),
        ];

        if ($company) {
            $company->update($createData);
        } else {
            $company = Company::create($createData);
        }

        if (!$request->get('id')) {
            $company->ownerMembers()->updateOrCreate([
                'user_id' => auth()->id(),
                'company_id' => $company->id,
                'role' => CompanyMember::ROLE_OWNER
            ]);
        }

        $company->save();

        return redirect()->route('profile.show',['tab' => 'companies']);
    }


    public function companyDestroy(Company $company){
        try {
            $company->delete();
        } catch (\Exception $ex) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'validation_error' => [__('მონაცემის წაშლა ვერ მოხერხდა')],
            ]);
            throw $error;
        }
        return redirect()->route('profile.show',['tab' => 'companies']);
    }

}
