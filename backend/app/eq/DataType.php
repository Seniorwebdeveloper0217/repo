<?php

namespace App\Eq;

use Illuminate\Database\Eloquent\Model;

class DataType extends Model
{
    //
    protected $table = 'data_types';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        "id",
        "name",
        "description",
    ];
}
