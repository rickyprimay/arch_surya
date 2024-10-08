<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function programs()
    {
        return $this->hasMany(Programs::class, 'division_id');
    }
}
