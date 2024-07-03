<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table ="inventory";
    protected $primaryKey = 'INVENTORY_ID';
    public $timestamps = true;
    protected $keyType = 'string';
    protected $fillable = [
        'INVENTORY_ID',
        'ASSET_ID',
        'ASSET_NAME',
        'ASSET_TAG',
        'ASSET_SUB_TYPE',
        'ASSET_CATEGORY',
        'SERIAL_NO',
        'MANUFACTURER',
        'ASSET_DESCRIPTION',
        'COLOR',
        'WEIGHT',
        'DIMENSION',
        'ASSIGNED_USER',
        'LOCATION_ID',
        'LOCATION',
        'STATUS',
        'USE_POLICY',
        'SERVICE_LEVEL',
        'PRIORITY_LEVEL',
        'BARCODE',
        'PURCHASE_ORDER_NO',
        'PURCHASE_DATE',
        'VENDOR_ID',
        'VENDOR',
        'ASSET_AGE',
        'USEFUL_LIFE',
        'IN_SERVICE_DATE',
        'WARRANTY_TERMS',
        'WARRANTY_START_DATE',
        'WARRANTY_EXPIRY',
        'GROUP_ID',
        'STATUS'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class,'ASSET_ID', 'ASSET_ID');
    }


    public function assetTransferAssetDetails()
    {
        return $this->hasMany(AssetTransferAssetDetail::class, 'SERIAL_NO', 'SERIAL_NO');
    }
}
