<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function publications() {
        return $this->belongsToMany(Publication::class, 'publication_tags');
    }

    public function datasets() {
        return $this->belongsToMany(Dataset::class, 'dataset_tags');
    }
}
