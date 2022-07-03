<?php

namespace App\Models;
use App\Traits\HasExcludeScope;
use App\Traits\HasMailable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasExcludeScope, HasMailable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avatar(): Attribute
    {
        return Attribute::make(
            get: function($val) {
                $avatar = !is_null($val) ? $val : 'https://ui-avatars.com/api/?name='.$this->name.'&background=random&v=' . rand(0, 999999);
                if(Str::contains(request()->url(), '/api')){
                    return asset($avatar);
                }
                return $avatar;
            }
        );
    }

    public function username(): Attribute
    {
        return Attribute::make(
            set: function($val) {
                return Str::lower($val);
            },
        );
    }

    public function name(): Attribute
    {
        return Attribute::make(
            set: function($val) {
            return Str::title($val);
        },
        );
    }


    public function scopeNotRole(Builder $query, $roles, $guard = null): Builder
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

    public function verificationToken(): HasOne
    {
        return $this->hasOne(VerificationToken::class);
    }
}
