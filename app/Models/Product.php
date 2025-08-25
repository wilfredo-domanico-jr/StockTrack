<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "product_list";
    protected $primaryKey = 'PRODUCT_ID';
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'PRODUCT_ID',
        'PRODUCT_CATEGORY',
        'PRODUCT_NAME',
        'PRODUCT_DESCRIPTION',
        'COLOR',
        'WEIGHT',
        'DIMENSION',
        'LOGO',
        'MANUFACTURER',
        'VENDOR_ID',
        'USEFUL_LIFE',
        'STATUS',
        'SERVICE_PROVIDER',
        'LOGISTIC_PARTNER',
        'FROM_DATE',
        'REMARKS',
        'EQUIPMENT_MODEL',
        'PRODUCT_CONDITION',
        'DELETED'
    ];



    public function findOne()
    {
        return $this->belongsTo(ProductCategory::class, 'PRODUCT_CATEGORY', 'id');
    }


    public function store($dataToInsert)
    {
        self::insert($dataToInsert);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'PRODUCT_CATEGORY');
    }
}
