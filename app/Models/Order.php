<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    protected $fillable = ['restaurant_id', 'user_id', 'total_cost', 'order_time', 'status'];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}