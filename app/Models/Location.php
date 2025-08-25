<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'postal_code',
        'phone',
        'email',
        'opening_hours_weekdays',
        'closing_hours_weekdays',
        'opening_hours_weekends',
        'closing_hours_weekends',
    ];

    protected $casts = [
        'opening_hours_weekdays' => 'datetime',
        'closing_hours_weekdays' => 'datetime',
        'opening_hours_weekends' => 'datetime',
        'closing_hours_weekends' => 'datetime',
    ];

    public function drivers()
    {
        return $this->belongsToMany(User::class, 'driver_locations', 'location_id', 'driver_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
