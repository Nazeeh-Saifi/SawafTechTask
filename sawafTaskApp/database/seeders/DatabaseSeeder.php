<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //======== Supplier Table ==========
        Supplier::create([
            "CompanyName"=> "SwafTech",
            "ContactName" => "Ahmad" ,
            "City"=>  "Damascus",
            "Country"=> "Syria",
            "Phone"=> "33324587",
            "Fax"=> "33324588",
        ])->products()->createMany([
            [
                "ProductName" => "Chai",
                "UnitPrice" => 150,
            ],
            [
                "ProductName" => "Rice",
                "UnitPrice" => 300,
            ],
        ]);
        
        Supplier::create([
            "CompanyName"=> "Durra",
            "ContactName" => "سعيد" ,
            "City"=>  "دمشق",
            "Country"=> "سوريا",
            "Phone"=> "0113855454",
        ])->products()->create([
        
                "ProductName" => "Sugar",
                "UnitPrice" => 250,
            
        ]);

        Supplier::create([
            "CompanyName"=> "كهربائيات المصري",
            "ContactName" => "محمود" ,
            "City"=>  "حلب",
            "Country"=> "سوريا",
        ])->products()->create([
        
            "ProductName" => "Biscuit",
            "UnitPrice" => 500,  
        ]);


         //======== Customer Table ==========
         Customer::create([
            "FirstName"=> "Mohamad",
            "LastName" => "Zid" ,
            "City"=>  "Beirut",
            "Country"=> "Lebanon",
            "Phone"=> "02015485546",
        ])->orders()->create([
            "OrderDate" => Carbon::create(2020, 7, 5, 0, 0, 0, 0),
            "OrderNumber" => 5,
            "TotalAmount" => 1000,
        ]);
        
        Customer::create([
            "FirstName"=> "Samer",
            "LastName" => "Salam" ,
            "City"=>  "Damascus",
            "Country"=> "Syria",
            "Phone"=> "555456687",
        ])->orders()->create([
            "OrderDate" => Carbon::create(2020, 8, 14, 0, 0, 0, 0),
            "OrderNumber" => 8,
            "TotalAmount" => 600,

        ]);

        //======== Order Item Table ===========
        $order1 = Order::find(1);
        $order2 = Order::find(2);

        // $product2 = Product::find(2);
        // $product3 = Product::find(3);
        // $product4 = Product::find(4);

        $order1->products()->attach([
            4 => ["UnitPrice" => 500,"Quantity" => 2],
        ]);
        $order2->products()->attach([
            3 => ["UnitPrice" => 300,"Quantity" => 1],
            2 => ["UnitPrice" => 300,"Quantity" => 1],
        ]);
       
       
    }
}
