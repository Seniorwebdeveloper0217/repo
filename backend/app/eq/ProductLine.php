<?php

namespace App\Eq;

use Illuminate\Database\Eloquent\Model;

class ProductLine extends Model
{
    //
    protected $table = 'product_lines';
    protected $connection = 'mysql2';
    public $timestamps = false;

    protected $fillable = [
        "name",
        "backup_manager",
        "lead_designer",
        "line_manager",
        "short_description",
        "company_id",
        "equipment_category_id",
        "overview",
        
    ];
}
