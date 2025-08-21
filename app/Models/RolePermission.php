<?php

namespace App\Models;

use Faker\Provider\el_GR\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $primaryKey = 'ROLE_ID';
    protected $keyType = 'string';
    protected $table = 'user_role_permission';
    public $timestamps = false;
    protected $fillable = [
        'ROLE_ID',
        'PRODUCT_CATALOG',
        'ADD_PRODUCT',
        'EDIT_PRODUCT',
        'DELETE_PRODUCT',
        'ADD_ASSET_CATEGORY',
        'EDIT_ASSET_CATEGORY',
        'DELETE_ASSET_CATEGORY',
        'INVENTORY',
        'CREATE_ASSET_TRANSFER',
        'RECEIVE_ASSET_TRANSFER',
        'SUPPLIER',
        'ADD_SUPPLIER',
        'EDIT_SUPPLIER',
        'DELETE_SUPPLIER',
        'ADMIN',
        'ADD_USER',
        'DELETE_USER',
        'ADD_LOCATION',
        'EDIT_LOCATION',
        'DELETE_LOCATION',
        'ADD_ROLE',
        'EDIT_ROLE',
        'DELETE_ROLE',
        'MANAGE_ROLE_ACCESS',

    ];


}
