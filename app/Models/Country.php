<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
  public function Victim()
  {
    return $this->hasManyThrough('App\Models\Victim', 'App\Models\Family');
  }
}
