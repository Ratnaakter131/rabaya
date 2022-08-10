<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    function rel_to_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    function rel_to_subcategory(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }
    function inventories(){
        return $this->hasMany(Inventory::class, 'id');
    }

    protected $guarded = ['id'];
}
