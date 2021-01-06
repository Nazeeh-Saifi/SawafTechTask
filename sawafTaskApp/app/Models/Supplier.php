<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $guarded = ['id'];  
    public $timestamps = false;


    public function products(){
        return $this->hasMany("App\Models\Product","SupplierId");
    }
}
