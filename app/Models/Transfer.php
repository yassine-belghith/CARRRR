<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference_number',
        'user_id',
        'driver_id',
        'driver_confirmation_status',
        'job_status',
        'job_started_at',
        'job_completed_at',
        'car_id',
        'pickup_location_id',
        'dropoff_location_id',
        'pickup_latitude',
        'pickup_longitude',
        'pickup_location_name',
        'dropoff_latitude',
        'dropoff_longitude',
        'dropoff_location_name',
        'pickup_datetime',
        'return_datetime',
        'flight_number',
        'airline',
        'passenger_count',
        'luggage_count',
        'status',
        'price',
        'currency',
        'payment_status',
        'payment_method',
        'payment_id',
        'special_instructions',
        'driver_notes',
        'cancellation_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $appends = ['status_label', 'status_badge_class'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pickup_datetime' => 'datetime',
        'return_datetime' => 'datetime',
        'job_started_at' => 'datetime',
        'job_completed_at' => 'datetime',
        'price' => 'decimal:2',
        'pickup_latitude' => 'float',
        'pickup_longitude' => 'float',
        'dropoff_latitude' => 'float',
        'dropoff_longitude' => 'float',
    ];

    /**
     * Get the user who booked the transfer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the driver assigned to the transfer.
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * Get the car used for the transfer.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Pickup and dropoff destination relationships.
     */
    public function pickupDestination()
    {
        return $this->belongsTo(Destination::class, 'pickup_location_id');
    }

    public function dropoffDestination()
    {
        return $this->belongsTo(Destination::class, 'dropoff_location_id');
    }

    /**
     * Get the human-readable status label.
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmé',
            'assigned' => 'Assigné',
            'on_the_way' => 'En route',
            'driver_en_route' => 'En route',
            'driver_arrived' => 'Chauffeur arrivé',
            'in_progress' => 'En cours',
            'completed' => 'Terminé',
            'cancelled' => 'Annulé',
            'no_show' => 'Non-présentation',
        ];

        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Get the Bootstrap badge class for the status.
     *
     * @return string
     */
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'pending' => 'secondary',
            'confirmed' => 'primary',
            'assigned' => 'info',
            'on_the_way' => 'warning',
            'driver_en_route' => 'warning',
            'driver_arrived' => 'info',
            'in_progress' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            'no_show' => 'dark',
        ];

        return $classes[$this->status] ?? 'light';
    }

}
