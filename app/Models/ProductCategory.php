<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = "product_category";
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'CATEGORY_NAME'
    ];
}
