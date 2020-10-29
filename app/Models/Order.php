<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\OrderedItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'address', 'status', 'payment_method', 'comment'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orderedItems() {
        return $this->hasMany(OrderedItem::class);
    }
}
