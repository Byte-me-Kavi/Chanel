<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'orders';

    /**
     * The primary key for the model (default is 'id').
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     * The legacy table uses 'created_at' and 'order_date', not updated_at
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
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

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'order_date' => 'datetime',
    ];
}
