<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VicTalent extends Model
{
  protected $table='vic_talent';
    public function Talent(){
      return $this->belongsTo(Talent::class);
    }
  public function Victim(){
    return $this->belongsTo(Victim::class);
  }
}
