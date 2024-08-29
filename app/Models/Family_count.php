<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family_count extends Model
{
    public function Big_family(){
        return $this->belongsTo(BigFamily::class);
    }
}
