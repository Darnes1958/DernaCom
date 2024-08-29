<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archif extends Model
{
  public function Family(){
    return $this->belongsTo(Family::class);
  }
  public function Street(){
    return $this->belongsTo(Street::class);
  }
}
