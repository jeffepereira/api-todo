<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    protected $dates = ['finished_at'];

    protected $appends = ['complete'];

    public function getCompleteAttribute()
    {
        return $this->finished_at ? true : false;
    }
}
