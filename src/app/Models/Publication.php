<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Publication extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'name',
        'excerpt',
        'abstract',
        'download_link',
        'status'
    ];

    public function authors() {
        return $this->belongsToMany(User::class, 'user_publications', 'publication_id', 'user_id')->where('is_review', false);
    }

    public function reviewers() {
        return $this->belongsToMany(User::class, 'user_publications', 'publication_id', 'user_id')->where('is_review', true)
        ->withPivot('review_comment', 'reviewed_at');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'publication_tags', 'publication_id', 'tag_id');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
