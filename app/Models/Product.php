<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'chategory_id',
        'user_id',
        'product',
        'description',
        'price',
        'stock',
        'image',
    ];
    public function product(): BelongsTo

    {
        return $this->belongsTo(Product::class);
    }
}
