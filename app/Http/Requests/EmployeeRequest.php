<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "fname" => ["required", "string", "max:255"],
            // "mname" => "May",
            "lname" => ["required", "string", "max:255"],
            "gender" => ["required"],
            "email" => ["required", "string", "max:255", "unique:employee,email"],
            "nationality" => ["required"],
            "status" => ["required"],
            "bithdate" => ["required"],
            "department" => ["required"],
            "position" => ["required"],
            "linemanager" => ["required"],
            "branch" => ["required"],
            "ctype" => ["required"],
            "salary" => ["required"],
            "currency" => ["required"],
            "cost_center" => ["required"],
            "contract_start" => ["required"],
            "contract_end" => ["required"],
            "leave_day" => ["required", "numeric"],
            // "pension_fund" => "1",
            // "pf_membership_no" => "8337238237283782",
            "emp_id" => ["required", "unique:employee,emp_id"],
            "bank" => ["required"],
            "bank_branch" => ["required"],
            "accno" => ["required"],
            // "mobile" => "0656205600",
            // "postaddress" => "Mollit exercita",
            // "postalcity" => "Dignissimos com",
            // "phyaddress" => "Nulla ea esse sunt enim a",
            // "haddress" => "Et voluptates ipsum nost",
            "nationalid" => ["required"],
            "tin" => ["required"],
            "emp_level" => ["required"],
        ];
    }
}
