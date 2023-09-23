<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 
        'last',
        'first', 
        'indicatifphone',
        'phone',
        'email',
        'linkedin'
    ];

    public function customer() {
        return $this->belongsTo('App\Models\Customer');
    }
}
