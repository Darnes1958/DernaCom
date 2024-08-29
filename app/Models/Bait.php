<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bait extends Model
{
   public function Family(){
     return $this->belongsTo(Family::class);
   }
   public function Victim(){
     return $this->hasMany(Victim::class);
   }
}
