<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'course_id',
        'title',
        'price',
        'quantity',
        'total_amount',
        'phone',
        'transaction_id',
        'payment_method',
        'payment_status',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
