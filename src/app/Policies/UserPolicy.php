<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
  use HandlesAuthorization;

  public function createStoreRepresentative(User $user)
  {
    return $user->is_admin;
  }

  public function isAdmin(User $user)
  {
    return $user->is_admin;
  }

  public function isStoreRepresentative(User $user)
  {
    return $user->is_store_representative;
  }
}
