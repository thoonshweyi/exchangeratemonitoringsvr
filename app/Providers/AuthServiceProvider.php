<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Log;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
     */
    public function boot(): void
    {
        $this->registerPolicies();

          // Passport::loadKeysFrom(storage_path('secrets/oauth'));
          // Load keys from custom directory
          Passport::loadKeysFrom(base_path('secrets/oauth'));

          // Debugging Tips
          if(!file_exists(base_path('secrets/oauth/private.key')) || !file_exists(base_path('secrets/oauth/public.key'))){
               Log::error("oauth keys are missing");
          }else{
            //    \Log::error("oauth keys are exists");
          }
    }
}
