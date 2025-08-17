<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'car_id',
        'maintenance_date',
        'type',
        'description',
        'cost',
        'service_provider',
        'mileage',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'maintenance_date' => 'date',
        'cost' => 'decimal:2',
    ];

    /**
     * Get the car that this maintenance record belongs to.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
