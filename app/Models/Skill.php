<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Skill extends Model
{
    use HasFactory;
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'level'
    ];

    /**
     * Get all of the Talents that are assigned this skill.
     */
    // public function talents(): MorphToMany
    // {
    //     return $this->morphedByMany(Talent::class, 'skillable');
    // }
    public function talents(): MorphToMany
    {
        return $this->morphedByMany(Talent::class, 'skillable');
    }
 
    /**
     * Get all of the Jobs that are assigned this skill.
     */
    public function jobs(): MorphToMany
    {
        return $this->morphedByMany(Job::class, 'skillable');
    }
}
