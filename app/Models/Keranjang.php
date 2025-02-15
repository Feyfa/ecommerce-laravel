<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['product'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
