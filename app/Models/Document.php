<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'division_id', 'file', 'created_by'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
