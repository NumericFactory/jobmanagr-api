<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
        'isRemote',
        'duration',
        'tjmin',
        'tjmax',
        'startDate',
        'city',
        'country',
        'info',
        'status',
    ];
    
    /**
     * Get all of the skill for the job.
     */
    public function skills(): MorphToMany
    {
        return $this->morphToMany(Skill::class, 'skillable');
    }
	

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

}
