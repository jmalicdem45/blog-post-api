<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'comment',
        'level',
        'parent_id',
    ];

    public function parent() {
        return $this->belongsTo(static::class, 'parent_id')->where('parent_id', 0)->with('parent');
    }

    public function children() {
        return $this->hasMany(static::class, 'parent_id')->orderBy('id', 'DESC')->with('children');
    }
}
