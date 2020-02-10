<?php

namespace App\Eq;

use Illuminate\Database\Eloquent\Model;

class UnitType extends Model
{
    //
    protected $table = 'unit_types';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        "id",
        "name",
    ];
}
