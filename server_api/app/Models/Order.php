<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function deliveredBy () {
        return $this->belongsTo(User::class, 'delivered_by');
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}


