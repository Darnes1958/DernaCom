<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tribe extends Model
{
    use HasFactory;

    public function families(){
      return $this->hasMany(Family::class);
    }
  public function Victim()
  {
    return $this->hasManyThrough('App\Models\Victim', 'App\Models\Family');
  }

}
