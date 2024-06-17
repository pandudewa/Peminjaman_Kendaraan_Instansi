@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Booking Approval</h1>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->vehicle->name }}</td>
                            <td>{{ $booking->driver->name }}</td>
                            <td>{{ $booking->date }}</td>
                            <td>{{ $booking->status }}</td>
                            <td>
                                <a href="{{ route('approvals.show', $booking->id) }}" class="btn btn-primary">See</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
