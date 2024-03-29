<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
		'order_id', 'order_local_number', 'product_id', 'status', 'price', 'notes', 'custom',
    ];

    public $timestamps = false;
}
