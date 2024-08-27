<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendas extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'duration_a', 
        'duration_r', 
        'created_by', 
        'start_dt_a', 
        'start_dt_r', 
        'end_dt_a', 
        'end_dt_r', 
        'city_id', 
        'program_id',
        'updated_date',
        'updated_actual',
        'information',
        'document'
    ];

    public function city()
    {
        return $this->belongsTo(Cities::class);
    }

    public function program()
    {
        return $this->belongsTo(Programs::class);
    }
}
