<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{

    protected $table = 'authors';
    protected $primaryKey = 'id';
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->second_name;
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

}