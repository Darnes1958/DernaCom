<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
    use HasFactory;
    public function Street(){
        return $this->hasMany(Street::class);
    }

    public function Victim()
    {
        return $this->hasManyThrough('App\Models\Victim', 'App\Models\Street');
    }
}
