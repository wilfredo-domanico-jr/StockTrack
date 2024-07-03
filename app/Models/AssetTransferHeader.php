<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTransferHeader extends Model
{
    use HasFactory;

    protected $table ="asset_transfer_header";
    protected $primaryKey = 'ASSET_TRANSFER_NO';
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'ASSET_TRANSFER_NO',
        'TRANSACTION_DATE',
        'TRANSFERED_LOCATION_ID',
        'LOCATION_ID',
        'DATE_RECEIVED',
        'TRANSFER_STATUS',
    ];


    public function assetTransferAssetDetails()
    {
        return $this->hasMany(AssetTransferAssetDetail::class,'ASSET_TRANSFER_NO');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'TRANSFERED_LOCATION_ID', 'LOCATION_ID');
    }


}
