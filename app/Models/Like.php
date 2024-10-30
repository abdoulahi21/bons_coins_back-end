<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Place;
use App\Models\User;
class Like extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'place_id',
    ];
    public function place(){
        return $this->belongsTo(Place::class);
    }
}
