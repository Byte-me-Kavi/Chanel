<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliveries';

    // handled manually
    public $timestamps = false;

    protected $fillable = [
        'order_number',
        'item_name',
        'item_category',
        'delivery_code',
        'courier_id',
        'status',
        'customer_name',
        'address',
        'product',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'created_at' => 'datetime',
    ];
}
