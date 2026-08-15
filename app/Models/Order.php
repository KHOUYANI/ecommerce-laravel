<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'customer_name',
        'customer_phone',
        'city',
        'address',
        'total_amount',
        'status',
        'admin_notes',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}