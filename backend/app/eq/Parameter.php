<?php

namespace App\Eq;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    //
    protected $table = 'parameters';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        "name",
        "equipment_class_id",
        "units",
        "units_id",
        "is_formula",
        "formula",
        "type_id",
    ];
}
