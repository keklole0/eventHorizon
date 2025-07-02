<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 
        'age_limit', 
        'date_start', 
        'date_end', 
        'description', 
        'preview_image', 
        'main_image', 
        'price',
        'max_participants',
        'status',
        'user_id', 
        'address_id', 
        'category_id',
        'likes_count',
        'comments_count'
    ];

    // Разрешаем массовое заполнение participations
    protected $with = ['participations'];

    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'event_tag');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(EventLike::class);
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'participations');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($event) {
            $event->update(['comments_count' => 0]);
        });
    }
}
