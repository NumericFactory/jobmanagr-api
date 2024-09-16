<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $table = 'documents';
    protected $fillable = ['link', 'file_name', 'job_id'];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

}