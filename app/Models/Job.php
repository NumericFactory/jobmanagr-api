<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 
        'customer_id',
        'description',
        'isremote',
        'duration',
        'tjmin',
        'tjmax',
        'startDate',
        'city',
        'country',
        'info',
        'status',
    ];
    
	

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
