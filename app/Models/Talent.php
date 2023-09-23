<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    use HasFactory;

    protected $table = 'talents';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last', 
        'first',
        'xp',
        'tjm',
        'city',
        'country',
        'remote',
        'linkedin',
        'indicatifphone',
        'phone',
        'email'
    ];
    
	

    public function skills()
    {
       // return $this->belongsTo('App\Models\Customer');
    }
}
