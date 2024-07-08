<?php

namespace App\Http\Requests\Auth;

use App\Helpers\SysHelpers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\RateLimiter;
use function PHPUnit\Framework\throwException;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "emp_id" => ["required"],
            "password" => ["required", "string"],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $state = $this->activated($this->input("emp_id"));

        if ($state == 0) {
            throw ValidationException::withMessages([
                "emp_id" => trans("auth.deactivated"),
            ]);
        } elseif ($state === "UNKNOWN" || $state == 4) {
            throw ValidationException::withMessages([
                "emp_id" => trans("auth.failed"),
            ]);
        } else {
            $this->ensureIsNotRateLimited();

            if (!Auth::attempt($this->only("emp_id", "password"))) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    "emp_id" => trans("auth.failed"),
                ]);
            }

            RateLimiter::clear($this->throttleKey());

            $password = $this->input("password");

            Auth::logoutOtherDevices($password);
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $empID = $this->input("emp_id");

        $datalog = [
            "state" => 0,
            "empID" => $empID,
            "author" => $empID,
        ];

        $this->employeestatelog($datalog);

        event(new Lockout($this));

        throw ValidationException::withMessages([
            "emp_id" => trans("auth.deactivated"),
        ]);

        // $seconds = RateLimiter::availableIn($this->throttleKey());

        // throw ValidationException::withMessages([
        //     'emp_id' => trans('auth.throttle', [
        //         'seconds' => $seconds,
        //         'minutes' => ceil($seconds / 60),
        //     ]),
        // ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::transliterate(
            Str::lower($this->input("emp_id")) . "|" . $this->ip()
        );
    }

    public function activated($empID)
    {
        $query = DB::table("employee")
            ->select("state")
            ->where("emp_id", $empID)
            ->limit(1)
            ->first();

        if ($query) {
            return $query->state;
        } else {
            return "UNKNOWN";
        }
    }

    public function employeestatelog($data)
    {
        $query = DB::transaction(function () use ($data) {
            $empID = $data["empID"];
            $state = $data["state"];
            $query =
                "UPDATE employee SET state = '" .
                $state .
                "' WHERE emp_id = '" .
                $empID .
                "'";

            DB::insert(DB::raw($query));

            DB::table("activation_deactivation")->insert($data);

            return true;
        });

        return $query;
    }
}
