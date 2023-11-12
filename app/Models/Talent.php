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
        'address',
        'complementaddress',
        'cp',
        'city',
        'country',
        'remote',
        'linkedin',
        'indicatifphone',
        'phone',
        'email',
        'siren',
        'nic',
        'siret',
        'nda',
    ];
    
    /**
     * Get all of the skill for the talent.
     */
    public function skills()
    {
        return $this->morphToMany(Skill::class, 'skillable');
    }

   

}
