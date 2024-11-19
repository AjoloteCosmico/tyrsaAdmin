<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;
    public function internalOrders()
    {
        return $this->hasMany(InternalOrder::class, 'seller_id');
    }
}
