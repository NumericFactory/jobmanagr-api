<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
     * Get all of the skills for the talent.
     */
    public function skills(): MorphToMany
    {
        return $this->morphToMany(Skill::class, 'skillable');
    }

    /**
     * Get all of the resumes for the talent.
     */
    public function resumes() {
        return $this->hasMany(Resume::class);
    }

    /**
     * Get all of the contracts for the talent.
     */
    public function contracts() {
        return $this->hasMany(TalentContract::class);
    }

    


   

}
