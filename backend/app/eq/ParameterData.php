<?php

namespace App\Eq;

use Illuminate\Database\Eloquent\Model;

class ParameterData extends Model
{
    //
    protected $table = 'parameters_data';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        "value",
        "par",
        "eq",
    ];
}
