<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

  public function Bait(){
    return $this->hasMany(Bait::class);
  }
    public function Victim(){
      return $this->hasMany(Victim::class);
    }
  public function Mafkoden(){
    return $this->hasMany(Mafkoden::class);
  }
  public function Tasreeh(){
    return $this->hasMany(Tasreeh::class);
  }
    public function Bedon(){
        return $this->hasMany(Bedon::class);
    }
  public function Dead(){
    return $this->hasMany(Dead::class);
  }
    public function Balag(){
        return $this->hasMany(Balag::class);
    }
    public function Tribe(){
      return $this->belongsTo(Tribe::class);
    }
    public function Big_family(){
        return $this->belongsTo(BigFamily::class);
    }
    public function Country(){
        return $this->belongsTo(Country::class);
    }
}
