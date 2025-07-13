<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'vendor_id',
        'unit',
        'name',
        'qty',
        'price'
    ];

    protected $casts = [
        "vendor_id" => "integer",
        "qty" => "integer",
        "price" => "float",
        "unit" => "string",
        "created_at" => "datetime",
        "updated_at" => "datetime"
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
