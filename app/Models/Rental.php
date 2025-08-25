<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
        protected $fillable = [
        'user_id',
        'car_id',
        'location_id',
        'driver_id',
        'rental_date',
        'return_date',
        'total_price',
        'status',
        'notes',
        'needs_driver',
        'driver_license_path'
    ];

    protected $dates = [
        'rental_date',
        'return_date',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'rental_date' => 'datetime',
        'return_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'total_price' => 'decimal:2',
        'needs_driver' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}

