<?php

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'person_id', 'vehicle_id', 'driver_id', 'start_time', 'end_time', 'destination', 'purpose', 'status',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }
}