<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransferHeader extends Model
{
    use HasFactory;

    protected $table = "inventory_transfer_header";
    protected $primaryKey = 'INVENTORY_TRANSFER_NO';
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'INVENTORY_TRANSFER_NO',
        'TRANSACTION_DATE',
        'TRANSFERED_LOCATION_ID',
        'LOCATION_ID',
        'DATE_RECEIVED',
        'TRANSFER_STATUS',
    ];


    public function inventoryTransferProductDetails()
    {
        return $this->hasMany(InventoryTransferProductDetail::class, 'INVENTORY_TRANSFER_NO');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'TRANSFERED_LOCATION_ID', 'LOCATION_ID');
    }
}
