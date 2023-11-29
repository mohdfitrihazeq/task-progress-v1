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
                $query->where('project_company.company_id', $this->company_id);
                // ^ Specify the table alias for company_id
            })
            ->exists();

        // Check if the project name is unique for any other company
        $existsForOtherCompany = Project::where('project_name', $value)
            ->doesntHave('companies')
            ->exists();

        return !$existsForCompany && !$existsForOtherCompany;
    }

    public function message()
    {
        return 'The project name is not unique for the specified company or other companies.';
    }
}
