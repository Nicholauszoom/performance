<?php

namespace App\Rules;

use App\Models\EMPL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

class CurrentPasswordCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($emp_id)
    {
        $this->emp_id = $emp_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $employee = EMPL::where('emp_id',$this->emp_id)->first();
        if(Hash::check($value, $employee->password)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Current password is incorrect.';
    }
}
