<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'id';

    // legacy timestamps
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_name',
        'price',
        'image',
        'order_status',
        'quantity',
        'wrapping_option',
        'gift_message',
        'samples',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'order_date' => 'datetime',
    ];
}
