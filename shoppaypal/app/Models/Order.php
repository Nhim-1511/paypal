<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{
    //
     use HasFactory;

    protected $fillable = [
        'product_id',
        'amount',
        'payer_email',
        'paypal_order_id',
    ];

    // Một đơn hàng thuộc về một sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
