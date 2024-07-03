<?php

namespace App\Models;

use Faker\Provider\el_GR\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $table = 'roles';
    public $timestamps = false;
    protected $fillable = [
        'ROLE',
        'CREATED_BY',
        'UPDATED_BY',
        'DELETED',
    ];


}
