<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];  
    public $timestamps = false;

    public function customer(){
        return $this->belongsTo("App\Models\Customer","CustomerId");
    }

    public function products(){
        return $this->belongsToMany("App\Models\Product","order_items","OrderId","ProductId")->withPivot('UnitPrice', 'Quantity');
    }

}
