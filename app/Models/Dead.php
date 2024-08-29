<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dead extends Model
{
    public $timestamps = false;
    public function Family(){
        return $this->belongsTo(Family::class);
    }
    public function Victim(){
        return $this->belongsTo(Victim::class);
    }
}
