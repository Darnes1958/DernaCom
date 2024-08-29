<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BigFamily extends Model
{
    public function Tarkeba(){
        return $this->belongsTo(Tarkeba::class);
    }
    public function Family_count(){
        return $this->hasMany(Family_count::class);
    }
    public function Family(){
        return $this->hasMany(Family::class);
    }
  public function Victim()
  {
    return $this->hasManyThrough('App\Models\Victim', 'App\Models\Family');
  }
}
