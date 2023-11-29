<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Company;
use App\Models\Project;

class UniqueProjectForCompany implements Rule
{
    private $company_id;

    public function __construct($company_id)
    {
        $this->company_id = $company_id;
    }

    public function passes($attribute, $value)
    {
        // Check if the project name is unique for the specified company
        $existsForCompany = Project::where('project_name', $value)
            ->whereHas('companies', function ($query) {
                $query->where('project_company.company_id', $this->getCompanyId());
            })
            ->count() > 0;

        // Check if the project name is unique for any other company
        $existsForOtherCompany = Project::where('project_name', $value)
            ->doesntHave('companies')
            ->count() > 0;

        return !$existsForCompany && !$existsForOtherCompany;
    }

    private function getCompanyId()
    {
        // Determine the correct company_id based on user role
        if (\Auth::user()->role_name == 'Master Super Admin - MSA') {
            return $this->company_id;
        } else {
            return \Auth::user()->company_id;
        }
    }

    public function message()
    {
        return 'The project name has been taken.';
    }
}
