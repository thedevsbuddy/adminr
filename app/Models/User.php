<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get avatar attribute with full path
     *
     * @param $value
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        $avatar = !is_null($value) ? $value : 'https://ui-avatars.com/api/?name='.$this->name.'&background=random&v=' . rand(0, 999999);
        if(Str::contains(request()->url(), 'api')){
          return asset($avatar);
        }
        return $avatar;
    }

    /**
     * Stores username by transforming to lower case.
     *
     * @param $value
     * @return string
     */
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = Str::lower($value);
    }

    /**
     * Stores name by transforming to title case.
     *
     * @param $value
     * @return string
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::title($value);
    }


    /**
     * Scope the model query to certain roles only.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles
     * @param string $guard
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotRole(Builder $query, $roles, $guard = null)
    {
        if ($roles instanceof Collection) {
            $roles = $roles->all();
        }

        if (! is_array($roles)) {
            $roles = [$roles];
        }

        $roles = array_map(function ($role) use ($guard) {
            if ($role instanceof Role) {
                return $role;
            }

            $method = is_numeric($role) ? 'findById' : 'findByName';
            $guard = $guard ?: $this->getDefaultGuardName();

            return $this->getRoleClass()->{$method}($role, $guard);
        }, $roles);

        return $query->whereHas('roles', function (Builder $subQuery) use ($roles) {
            $subQuery->whereNotIn(config('permission.table_names.roles').'.id', \array_column($roles, 'id'));
        });
    }
}
