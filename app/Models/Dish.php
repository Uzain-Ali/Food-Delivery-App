<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Dish extends Model
{
    protected $fillable = ['restaurant_id', 'name', 'category', 'price', 'popularity_score', 'availability_status'];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
