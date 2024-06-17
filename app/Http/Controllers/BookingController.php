<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('vehicle', 'driver', 'person')->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $approvers = Person::where('role', 'supervisor')->get();
        return view('bookings.create', compact('vehicles', 'drivers', 'approvers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'destination' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'approver_id' => 'required|exists:persons,id',
        ]);

        $booking = new Booking();
        $booking->person_id = Auth::id();
        $booking->vehicle_id = $request->vehicle_id;
        $booking->driver_id = $request->driver_id;
        $booking->start_time = $request->start_time;
        $booking->end_time = $request->end_time;
        $booking->destination = $request->destination;
        $booking->purpose = $request->purpose;
        $booking->save();

        $booking->approvals()->create([
            'approver_id' => $request->approver_id,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    public function show($id)
    {
        $booking = Booking::with('vehicle', 'driver', 'person', 'approvals.approver')->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $approvers = Person::where('role', 'supervisor')->get();
        return view('bookings.edit', compact('booking', 'vehicles', 'drivers', 'approvers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'destination' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'approver_id' => 'required|exists:persons,id',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->vehicle_id = $request->vehicle_id;
        $booking->driver_id = $request->driver_id;
        $booking->start_time = $request->start_time;
        $booking->end_time = $request->end_time;
        $booking->destination = $request->destination;
        $booking->purpose = $request->purpose;
        $booking->save();

        $approval = $booking->approvals()->where('approver_id', $request->approver_id)->first();
        if ($approval) {
            $approval->status = 'pending';
            $approval->save();
        } else {
            $booking->approvals()->create([
                'approver_id' => $request->approver_id,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }

    
}
