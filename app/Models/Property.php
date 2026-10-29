<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'title',
        'description',
        'city',
        'district',
        'type',
        'transaction',
        'price',
        'area',
        'bedrooms',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'float',
            'area' => 'integer',
            'bedrooms' => 'integer',
        ];
    }
}