<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Idagdag ang customer_name at platform sa $fillable
    protected $fillable = ['transaction_id', 'method', 'amount', 'status', 'customer_name', 'platform'];
}