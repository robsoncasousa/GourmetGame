<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function dishes()
    {
        return $this->belongsToMany('App\Models\Dish');
    }
}
