<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Content;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'position', 'meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function contents()
    {
    return $this->hasMany(Content::class)->orderBy('position');
    }
}
