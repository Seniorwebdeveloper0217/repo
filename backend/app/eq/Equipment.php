<?php

namespace App\Eq;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    //
    protected $table = 'equipment';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        "name",
        "equipment_class_id"
    ];
}
