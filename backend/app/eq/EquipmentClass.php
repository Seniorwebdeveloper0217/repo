<?php

namespace App\Eq;

use Illuminate\Database\Eloquent\Model;

class EquipmentClass extends Model
{
    //
    protected $table = 'equipment_class';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        "eq",
        "description"
    ];
}
