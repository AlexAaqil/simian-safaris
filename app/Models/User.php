<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\UserRoleScopes;
use App\Enums\USER_ROLES;
use App\Enums\USER_STATUSES;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, UserRoleScopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'secondary_phone_number',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => USER_ROLES::class,
            'status' => USER_STATUSES::class,
        ];
    }

    public function isActive(): bool
    {
        return $this->status === USER_STATUSES::ACTIVE;
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === USER_ROLES::SUPER_ADMIN;
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, [
            USER_ROLES::SUPER_ADMIN,
            USER_ROLES::ADMIN,
            USER_ROLES::OWNER,
        ]);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->first_name, 0, 1).substr($this->last_name, 0, 1));
    }

    public function getPhoneNumbersAttribute(): string
    {
        // $format_phone_number = function ($phone_number) {
        //     if(!$phone_number || strlen($phone_number) !== 12 || !str_starts_with($phone_number, '254')) {
        //         return $phone_number;
        //     }

        //     $local = '0' . substr($phone_number, 3);
        //     return substr($local, 0, 4) . ' ' . substr($local, 4, 3) . ' ' . substr($local, 7);
        // };

        // $phone_numbers = array_filter([
        //     $this->phone_number,
        //     $this->secondary_phone_number,
        // ]);

        // $formatted_phone_numbers = array_map($format_phone_number, $phone_numbers);

        // return $formatted_phone_numbers ? implode(' | ', $formatted_phone_numbers) : '-';
        return $this->phone_number.''. $this->secondary_phone_number;
    }
}
