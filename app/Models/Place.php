<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Opinion;
use App\Models\Like;
class Place extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'address',
        'phone',
        'category',
        'image',
        'latitude',
        'longitude',
    ];
    public function getImageUrlAttribute()
    {
        return asset('storage/images/' . $this->image);
    }
    public function opinions()
    {
        return $this->hasMany(Opinion::class);
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
