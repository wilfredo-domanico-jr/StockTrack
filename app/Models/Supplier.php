<?php

namespace App\Models;

use Faker\Provider\el_GR\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'SUPPLIER_ID';
    protected $keyType = 'string';
    protected $table = 'supplier';
    public $timestamps = false;
    protected $fillable = [
        'SUPPLIER_ID',
        'SUPP_NAME',
        'TYPE',
        'CONTACT_NAME',
        'EMAIL',
        'CONTACT_NO',
        'ADDRESS',
        'UPDATED_BY',
        'DELETED',
    ];


    public function getAll(){
        return $this->where('DELETED',0)->get();
    }

}
