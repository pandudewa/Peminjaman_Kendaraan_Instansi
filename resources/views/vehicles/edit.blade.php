@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Edit Vehicle</h1>
            <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $vehicle->name }}" required>
                </div>
                <div class="form-group">
                    <label for="license_plate">License Plate</label>
                    <input type="text" name="license_plate" class="form-control" value="{{ $vehicle->license_plate }}" required>
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" class="form-control" required>
                        <option value="car" {{ $vehicle->type == 'car' ? 'selected' : '' }}>Car</option>
                        <option value="truck" {{ $vehicle->type == 'truck' ? 'selected' : '' }}>Truck</option>
                        <option value="bus" {{ $vehicle->type == 'bus' ? 'selected' : '' }}>Bus</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
