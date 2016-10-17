<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    protected $fillable = ['arabic', 'roman', 'times'];

    private $rules = array(
        'number' => 'required|min:1|max:3999',
    );

    public function scopeTop($query)
    {
        return $query->orderBy('times', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }
}
