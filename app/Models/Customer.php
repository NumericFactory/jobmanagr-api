<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'type',
        'isorganismeformation',
        'siren',
        'nic',
        'siret',
        'address',
        'complementaddress',
        'cp',
        'city',
        'country',
    ];
    
	

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }

    public function jobs()
    {
        return $this->hasMany('App\Models\Job');
    }
}
