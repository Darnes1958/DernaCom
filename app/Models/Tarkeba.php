<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarkeba extends Model
{
   public function Big_family(){
       return $this->hasMany(BigFamily::class);
   }
    public function Victim()
    {
        return $this->hasManyThrough('App\Models\Family_count', 'App\Models\BigFamily');
    }

}
