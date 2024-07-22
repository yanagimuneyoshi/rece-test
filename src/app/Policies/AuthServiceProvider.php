<?php

namespace App\Providers;

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
  protected $policies = [
    User::class => UserPolicy::class,
  ];

  public function boot()
  {
    $this->registerPolicies();

    Gate::define('isAdmin', [UserPolicy::class, 'isAdmin']);
    Gate::define('isStoreRepresentative', [UserPolicy::class, 'isStoreRepresentative']);
    Gate::define('createStoreRepresentative', [UserPolicy::class, 'createStoreRepresentative']);
  }
}

