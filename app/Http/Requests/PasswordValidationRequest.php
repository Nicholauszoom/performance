<?php

namespace App\Http\Requests;

use App\Rules\CurrentPassword;
use App\Rules\CheckOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class PasswordValidationRequest extends FormRequest
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
        $user = Auth::user();
        return [
            'current_password' => ['required', new CurrentPassword],

            'password' => [
                        'required',
                        Password::min(8)->letters()->numbers()->mixedCase()->symbols()->uncompromised(),
                        function ($attribute, $value, $fail) use( $user ){
                            if(Hash::check($value, Auth::user()->password)){
                                $fail('The '.$attribute.' should not match the current password.');
                            }
                        },
                        function ($attribute, $value, $fail) use( $user ){
                            if(strpos($value, $user->fname) !== false || strpos($value, $user->lname) !== false){
                                $fail('The '.$attribute.' should not contain user names.');
                            }
                        },
                        'confirmed',
                        new CheckOldPassword,
                    ],
        ];
    }
}
