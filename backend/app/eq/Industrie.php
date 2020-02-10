<?php

namespace App\Eq;

use Illuminate\Database\Eloquent\Model;

class Industrie extends Model
{
    //
    protected $table = 'industries';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        "name"
    ];
}
