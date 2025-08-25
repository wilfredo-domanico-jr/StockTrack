<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransferHeader extends Model
{
    use HasFactory;

    protected $table ="product_transfer_header";
    protected $primaryKey = 'PRODUCT_TRANSFER_NO';
    public $timestamps = false;
    protected $keyType = 'string';
    protected $fillable = [
        'PRODUCT_TRANSFER_NO',
        'TRANSACTION_DATE',
        'TRANSFERED_LOCATION_ID',
        'LOCATION_ID',
        'DATE_RECEIVED',
        'TRANSFER_STATUS',
    ];


    public function productTransferProductDetails()
    {
        return $this->hasMany(ProductTransferProductDetail::class,'PRODUCT_TRANSFER_NO');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'TRANSFERED_LOCATION_ID', 'LOCATION_ID');
    }


}
