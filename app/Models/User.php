<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Include the new 'role' attribute
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }
// In App\Models\User.php

public function issues()
{
    return $this->belongsToMany(Issue::class);
}
public function requests()
{
    return $this->belongsToMany(Request::class, 'request_user', 'user_id', 'request_id');
}

    /**
     * Check if the user has the 'Admin' role.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    /**
     * Check if the user has the 'User' role.
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->role === 'User';
    }
}
