<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Delivery extends Model
{
    protected $fillable = ['order_id', 'driver_id', 'delivery_time', 'estimated_duration'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}