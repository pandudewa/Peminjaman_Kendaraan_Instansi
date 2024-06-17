@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Driver Management</h1>
            <a href="{{ route('drivers.create') }}" class="btn btn-primary">Add Driver</a>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>License Number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $driver)
                        <tr>
                            <td>{{ $driver->name }}</td>
                            <td>{{ $driver->license_number }}</td>
                            <td>
                                <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" style="display:inline-block;">
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
