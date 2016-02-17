<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $table = 'books';
    protected $primaryKey = 'id';

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

}
