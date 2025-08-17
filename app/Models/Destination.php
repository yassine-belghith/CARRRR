<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'description',
        'is_active',
        'distance_from_airport_km',
        'estimated_drive_time_minutes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'is_active' => 'boolean',
        'distance_from_airport_km' => 'integer',
        'estimated_drive_time_minutes' => 'integer',
    ];

    /**
     * Get the pickup transfers for this destination.
     */
    public function pickupTransfers()
    {
        return $this->hasMany(Transfer::class, 'pickup_location_id');
    }

    /**
     * Get the dropoff transfers for this destination.
     */
    public function dropoffTransfers()
    {
        return $this->hasMany(Transfer::class, 'dropoff_location_id');
    }
}
