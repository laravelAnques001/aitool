<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Generator extends Model
{
    use HasFactory;

    protected $fillable = [
        'tool_id',
        'name',
        'link',
        'logo',
        'image',
        'status',
        'description',
        'deleted_at',
    ];

    protected $appends = [
        'logo_url',
        'image_url',
    ];

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset(Storage::url($this->logo)) : '';
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset(Storage::url($this->image)) : '';
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class, 'tool_id');
    }
}
