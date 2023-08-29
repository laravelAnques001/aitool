<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'status',
        'deleted_at',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset(Storage::url($this->image)) : '';
    }

    public function generator()
    {
        return $this->hasMany(Generator::class, 'tool_id');
    }
}
