@extends('layouts.admin.admin')

@section('title', 'Create New Workplace')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Workplace</h1>
        <a href="{{ route('admin.workplaces.index') }}" class="btn btn-secondary">Back to Workplaces</a>
    </div>

    <!-- Form for creating a new workplace -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Workplace Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.workplaces.store') }}" method="POST">
                @csrf

                <!-- Workplace Name -->
                <div class="form-group">
                    <label for="workplace">Workplace Name</label>
                    <input type="text" name="workplace" id="workplace" class="form-control" required>
                </div>

                <!-- Zip Code -->
                <div class="form-group">
                    <label for="zipcode">Zip Code</label>
                    <input type="text" name="zipcode" id="zipcode" class="form-control" required>
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                </div>

                <!-- Total Rooms -->
                <div class="form-group">
                    <label for="total_rooms">Total Rooms</label>
                    <input type="number" name="total_rooms" id="total_rooms" class="form-control" min="0">
                </div>

                <!-- Linen -->
                <div class="form-group">
                    <label for="linen">Linen</label>
                    <input type="text" name="linen" id="linen" class="form-control">
                </div>

                <!-- Nearest Laundromat Distance -->
                <div class="form-group">
                    <label for="nearest_laundromat_distance">Nearest Laundromat Distance (km)</label>
                    <input type="number" step="0.01" name="nearest_laundromat_distance" id="nearest_laundromat_distance" class="form-control">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Create Workplace</button>
            </form>
        </div>
    </div>
</div>
@endsection
