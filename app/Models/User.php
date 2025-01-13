<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'id',
        'email',
        'email_verified',
        'phone_number',
        'full_name',
        'address',
        'password',
        'provider_type'
    ];

    protected $hidden = [
        'password',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function assignRole(string $roleName): void
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            throw new Exception("Role '$roleName' does not exist.");
        }

        $this->roles()->attach($role->id);
    }

    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
