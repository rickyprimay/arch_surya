<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAgenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'status', 
        'title'
    ];
}
