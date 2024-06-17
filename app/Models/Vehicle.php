<?php

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'name', 'license_plate', 'type',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}