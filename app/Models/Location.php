<?php

namespace App\Models;

use Faker\Provider\el_GR\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $primaryKey = 'LOCATION_ID';
    protected $keyType = 'string';
    protected $table = 'location';
    public $timestamps = false;
    protected $fillable = [
        'LOCATION_ID',
        'LOCATION',
        'UPDATED_BY',
        'DELETED',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'LOCATION_ID', 'LOCATION_ID');
    }


}
