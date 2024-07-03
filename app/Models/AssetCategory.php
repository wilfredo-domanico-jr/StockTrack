<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    use HasFactory;

    protected $table ="asset_category";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'CATEGORY_NAME'
    ];


}
