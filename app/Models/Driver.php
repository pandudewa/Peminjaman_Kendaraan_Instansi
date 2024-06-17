<?php

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name', 'license_number',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}