<?php

namespace App\Models;

use App\Enums\Marry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hadam extends Model
{
  public $timestamps = false;
  public function H_area(){
    return $this->belongsTo(H_area::class);
  }
  public function Place_type(){
    return $this->belongsTo(Place_type::class);
  }
  public function Wakeel(){
    return $this->belongsTo(Wakeel::class);
  }

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts =[
    'marry' => Marry::class,

  ];
}
