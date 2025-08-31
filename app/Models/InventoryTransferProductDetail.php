<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransferProductDetail extends Model
{
    use HasFactory;

    protected $table = "inventory_transfer_product_details";
    protected $primaryKey = 'INVENTORY_ID';
    public $timestamps = true;
    protected $keyType = 'string';
    protected $fillable = [
        'INVENTORY_TRANSFER_NO',
        'SERIAL_NO'
    ];


    public function inventoryTransferHeader()
    {
        return $this->belongsTo(InventoryTransferHeader::class, 'INVENTORY_TRANSFER_NO', 'INVENTORY_TRANSFER_NO');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'SERIAL_NO', 'SERIAL_NO');
    }
}
