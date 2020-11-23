<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*use App\Model\Category;
use App\Model\OrderedItem;*/

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'price', 'image_url'];

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function orderedItem() {
        return $this->belongsTo(OrderedItem::class);
    }
}
