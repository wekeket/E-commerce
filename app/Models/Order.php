<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_code',
        'customer_id',
        'order_date',
        'total_amount',
        'payment_method',
        'status',
    ];
    
public function transaction()
{
    return $this->hasOne(CustomerTransaction::class);
}
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}