<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentContract extends Model
{
    use HasFactory;

    public function talent()
    {
        return $this->belongsTo('App\Models\Talent');
    }

    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }
}
