<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'admin', 
        'is_driver',
        'role', 
        'avatar',
        'theme',
        'language'
    ];
    
    protected $appends = ['avatar_url'];
    
    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return null;
        }
        
        // Check if the avatar path already contains 'storage/'
        if (strpos($this->avatar, 'storage/') === 0) {
            return asset($this->avatar);
        }
        
        // Check if the avatar path contains 'avatars/' already
        if (strpos($this->avatar, 'avatars/') === 0) {
            return asset('storage/' . $this->avatar);
        }
        
        // Default case: prepend 'storage/avatars/'
        return asset('storage/' . ltrim($this->avatar, '/'));
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get the driver record associated with the user.
     */
        public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    /**
     * Get the locations for the user.
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get the rentals assigned to the user as a driver.
     */
    public function assignedRentals()
    {
        return $this->hasMany(Rental::class, 'driver_id');
    }

    /**
     * Scope a query to only include drivers.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDrivers($query)
    {
        return $query->where('is_driver', true);
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
}