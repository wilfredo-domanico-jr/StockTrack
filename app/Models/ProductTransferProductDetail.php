<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransferProductDetail extends Model
{
    use HasFactory;

    protected $table = "product_transfer_product_details";
    protected $primaryKey = 'INVENTORY_ID';
    public $timestamps = true;
    protected $keyType = 'string';
    protected $fillable = [
        'PRODUCT_TRANSFER_NO',
        'SERIAL_NO'
    ];


    public function productTransferHeader()
    {
        return $this->belongsTo(ProductTransferHeader::class, 'PRODUCT_TRANSFER_NO', 'PRODUCT_TRANSFER_NO');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'SERIAL_NO', 'SERIAL_NO');
    }
}
