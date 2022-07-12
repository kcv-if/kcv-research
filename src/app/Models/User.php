<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
        'telephone'
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
    ];

    public function publications() {
        return $this->belongsToMany(Publication::class, 'user_publications', 'user_id', 'publication_id')->where('is_review', false);
    }

    public function reviewed_publications() {
        return $this->belongsToMany(Publication::class, 'user_publications', 'user_id', 'publication_id')->where('is_review', true);
    }

    public function datasets() {
        return $this->belongsToMany(Dataset::class, 'user_datasets', 'user_id', 'dataset_id')->where('is_review', false);
    }

    public function reviewed_datasets() {
        return $this->belongsToMany(Dataset::class, 'user_datasets', 'user_id', 'dataset_id')->where('is_review', true);
    }
}
