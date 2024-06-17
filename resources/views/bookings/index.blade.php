@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Vehicle Booking</h1>
            <a href="{{ route('bookings.create') }}" class="btn btn-primary">Create Booking</a>
            <a href="{{ route('export.bookings') }}" class="btn btn-success">Export to Excel</a>
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
                                <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
