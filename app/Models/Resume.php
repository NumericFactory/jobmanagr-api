<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;
    protected $table = 'resumes';
    protected $fillable = ['link', 'talent_id'];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }

}
