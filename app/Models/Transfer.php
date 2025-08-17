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
        'car_id',
        'pickup_latitude',
        'pickup_longitude',
        'dropoff_latitude',
        'dropoff_longitude',
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
        'price' => 'decimal:2',
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
            'completed' => 'success',
            'cancelled' => 'danger',
            'no_show' => 'dark',
        ];

        return $classes[$this->status] ?? 'light';
    }
}
