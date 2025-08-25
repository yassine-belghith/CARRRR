<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'license_number',
        'license_issue_date',
        'license_expiry_date',
        'phone',
        'address',
        'city',
        'country',
        'postal_code',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'license_issue_date' => 'date',
        'license_expiry_date' => 'date',
    ];

    /**
     * Get the user that owns the driver profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transfers assigned to this driver.
     */
    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'driver_id', 'user_id');
    }
}
