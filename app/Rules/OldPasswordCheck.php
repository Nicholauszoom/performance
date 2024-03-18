<?php

namespace App\Rules;

use App\Models\EMPL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Contracts\Validation\Rule;

class OldPasswordCheck implements Rule
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
        $employee= EMPL::where('emp_id',$this->emp_id)->first();
        $password = DB::table('user_passwords')
            ->select('password')
            ->where('empID', $employee->password)
            ->orderBy('id', 'desc')
            ->take(12)
            ->get();

        foreach ($password as $data) {
            if ( Hash::check($value, $data->password) ){
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must not resemble to the previous passwords.';
    }
}
