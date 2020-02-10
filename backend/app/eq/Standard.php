<?php

namespace App\Eq;

use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    //
    protected $table = 'standards';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        "name"
    ];
}
