<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
            'ticket_number',
		    'status',
            'customer_id',
            'total_price',
		    'total_paid',
		    'total_paid_with_points',
		    'points_gained',
		    'points_used_to_pay',
		    'payment_type',
		    'payment_reference',
		    'date',
    ];

    public function deliveredBy () {
        return $this->belongsTo(User::class, 'delivered_by');
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}


