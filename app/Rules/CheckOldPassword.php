<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Contracts\Validation\Rule;

class CheckOldPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $password = DB::table('user_passwords')
                        ->select('password')
                        ->where('empID', Auth::user()->emp_id)
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
