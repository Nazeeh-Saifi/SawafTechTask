<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];  
    public $timestamps = false;

    public function supplier(){
        return $this->belongsTo("App\Models\Supplier","SupplierId");
    }

    public function orders(){
        return $this->belongsToMany("App\Models\Order","order_items","ProductId","OrderId")->withPivot('UnitPrice', 'Quantity');
    }

}
