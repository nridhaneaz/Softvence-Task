<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'category', 'meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function modules()
    {
    return $this->hasMany(Module::class)->orderBy('position');
    }
}
