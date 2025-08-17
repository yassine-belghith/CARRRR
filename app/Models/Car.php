<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'year',
        'images',
        'availability',
        'registration_number',
        'description',
        'price_per_day'
    ];

    protected $casts = [
        'images' => 'array',
    ];
    
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get the maintenance records for the car.
     */
    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }
}

