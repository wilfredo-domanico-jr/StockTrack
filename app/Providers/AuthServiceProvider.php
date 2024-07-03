<?php

namespace App\Providers;

use App\Models\RolePermission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
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

        Gate::define('AuthorizeAction',function($user,$where){

            //Get Role Permission based on active Role

            $roles = RolePermission::where('ROLE_ID',$user->ROLE_ID)->get()->toArray();

            foreach($roles as $role):
                if($role[$where] == 1){
                    return true;
                }
            endforeach;

            return false;
        });



    }
}
