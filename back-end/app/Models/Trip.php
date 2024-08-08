<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsToMany(User::class);
    }
    
    public function journeyStages(){
        return $this->hasMany(JourneyStage::class);
    }
    
}
