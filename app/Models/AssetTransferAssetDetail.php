<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTransferAssetDetail extends Model
{
    use HasFactory;

    protected $table ="asset_transfer_asset_details";
    protected $primaryKey = 'INVENTORY_ID';
    public $timestamps = true;
    protected $keyType = 'string';
    protected $fillable = [
        'ASSET_TRANSFER_NO',
        'SERIAL_NO'
    ];


    public function assetTransferHeader()
    {
        return $this->belongsTo(AssetTransferHeader::class,'ASSET_TRANSFER_NO', 'ASSET_TRANSFER_NO');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class,'SERIAL_NO', 'SERIAL_NO');
    }
}
