<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Exception;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        try {

            DB::table('permission')->get()->map(function($permission){
                Gate::define($permission->name, function ($user) use ($permission){
                      $user = Auth::user();
                    return in_array($permission->name, json_decode($user->roles->permissions));
                });
            });

        } catch (Exception $e) {
            session()->flash("error", "No roles created yet");
        }

    }
}
