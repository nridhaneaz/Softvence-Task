<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'type', 'title', 'body', 'media_url', 'position', 'meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
