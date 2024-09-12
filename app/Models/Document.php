<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $fillable = ['link', 'job_id'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

}