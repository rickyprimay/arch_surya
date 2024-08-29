<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'created_by', 'city_id', 'division_id'];
    
    public function city()
    {
        return $this->belongsTo(Cities::class);
    }
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    public function agendas()
    {
        return $this->hasMany(Agendas::class, 'program_id');
    }
}
