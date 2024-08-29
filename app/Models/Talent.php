<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
  protected $table='talent';
  public function Victim(){
   return $this->hasMany(VicTalent::class);
  }
}
