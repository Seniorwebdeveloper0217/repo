<?php

namespace App\Eq;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    //
    protected $table = 'units';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        "type",
        "name",
    ];
}
