<?php

namespace App\Models;

use App\Enums\Subjects;
use Cohensive\OEmbed\Facades\OEmbed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts =[
    'subjects' => Subjects::class,

  ];

  /**
   * Get post video.
   *
   * @param string $value
   * @return string
   */
  public function getVideoAttribute($value){
    $oebed = OEmbed::get($value);
    if ($oebed){
      return $oebed->html(['width'=>200]);
    }
  }
}
