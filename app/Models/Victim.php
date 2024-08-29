<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Victim extends Model
{
    use HasFactory;
  public function Bait(){
    return $this->belongsTo(Bait::class);
  }
    public function User(){
      return $this->belongsTo(User::class);
    }
    public function Family(){
      return $this->belongsTo(Family::class);
    }
    public function Familyshow(){
        return $this->belongsTo(Familyshow::class);
    }
    public function Street(){
      return $this->belongsTo(Street::class);
    }

  public function wife(){
    return $this->belongsTo(self::class, 'husband_id');
  }
    public function wife2(){
        return $this->belongsTo(self::class, 'husband_id');
    }
  public function husband(){
    return $this->belongsTo(self::class, 'wife_id');
  }
  public function husband2(){
    return $this->belongsTo(self::class, 'wife2_id');
  }

    public function father(){
     return $this->hasMany(self::class, 'father_id');
    }
  public function mother(){
    return $this->hasMany(self::class, 'mother_id');
  }

  public function sonOfFather(){
    return $this->belongsTo(self::class, 'father_id');
  }
  public function sonOfMother(){
    return $this->belongsTo(self::class, 'mother_id');
  }

  public function Job(){
      return $this->belongsTo(Job::class);
  }
  public function Qualification(){
    return    $this->belongsTo(Qualification::class);
  }

  public function VicTalent(){
      return  $this->hasMany(VicTalent::class);
  }



  protected $casts = [
    'is_mother' => 'boolean',
    'is_father' => 'boolean',

  ];


}
