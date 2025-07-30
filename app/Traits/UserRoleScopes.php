<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Enums\USER_ROLES;
use Illuminate\Support\Facades\Auth;

trait UserRoleScopes
{
    /**
     * Scope to return users visible based on the role of the authenticated user.
     */

    public function scopeVisibleToRole(Builder $query, USER_ROLES $role): Builder
    {
        return match($role) {
            USER_ROLES::SUPER_ADMIN => $query, // See everyone
            USER_ROLES::ADMIN => $query->whereIn('role', [
                USER_ROLES::ADMIN,
                USER_ROLES::OWNER,
                USER_ROLES::USER,
            ]),
            USER_ROLES::USER => $query->where('id', Auth::user()->id), // See self only
        };
    }
}
