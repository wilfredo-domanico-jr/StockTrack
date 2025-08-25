<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = "inventory";
    public $timestamps = true;
    protected $keyType = 'string';
    protected $fillable = [
        'PRODUCT_ID',
        'SERIAL_NO',
        'LOCATION_ID',
        'PURCHASE_DATE',
        'STATUS'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'PRODUCT_ID', 'PRODUCT_ID');
    }


    public function productTransferProductDetails()
    {
        return $this->hasMany(ProductTransferProductDetail::class, 'SERIAL_NO', 'SERIAL_NO');
    }
}
