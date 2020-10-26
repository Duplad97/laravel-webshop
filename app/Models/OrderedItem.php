<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order;
use App\Models\Item;

class OrderedItem extends Model
{
    use HasFactory;

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function item() {
        return $this.belongsTo(Item::class);
    }
}
