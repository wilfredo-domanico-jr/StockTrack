<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "product_list";
    protected $primaryKey = 'ASSET_ID';
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'ASSET_ID',
        'ASSET_CATEGORY',
        'ASSET_NAME',
        'ASSET_DESCRIPTION',
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
        'ASSET_CONDITION',
        'DELETED'
    ];



    public function findOne()
    {
        return $this->belongsTo(AssetCategory::class, 'ASSET_CATEGORY', 'id');
    }


    public function store($dataToInsert)
    {
        self::insert($dataToInsert);
    }

    public function assetCategory()
    {
        return $this->belongsTo(AssetCategory::class, 'ASSET_CATEGORY');
    }
}
