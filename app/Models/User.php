<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use App\Traits\HasAvatar;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, MustVerifyEmailTrait, HasAvatar;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'phone',
        'role',
        'email',
        'password',
        'avatar',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function events()
    {
        return $this->hasMany(\App\Models\Event::class, 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function participations()
    {
        return $this->hasMany(\App\Models\Participation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Получить мероприятия, которые понравились пользователю.
     */
    public function likedEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_likes');
    }

    /**
     * Получить URL аватара пользователя (с учётом дефолтного)
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return \Storage::url($this->avatar);
        }
        return asset('images/default-avatar.svg');
    }
}
