<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'deliveries';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
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

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'quantity' => 'integer',
        'created_at' => 'datetime',
    ];
}
