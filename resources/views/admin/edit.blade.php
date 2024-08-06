@extends('layouts.adminnavigation')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('View Appointment') }}
    </h2>
@endsection

@section('content')
    <div class="container mx-auto mt-4 px-6">
        <p class="mb-2" ><b>Name: </b>{{ $user->name }}</p>
        <p class="mb-2"><strong>Phone Number:</strong> {{ $user->phone_number }}</p>
    </div>

    <div class="container mx-auto mt-2 px-6">
        <div class="card-body" style="margin-top: 20px; margin-bottom: 50px">
            <form method="POST" action="{{ route('admin.update', ['id' => $appointment->appointment_id]) }}">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="pet_name" class="form-label">Pet Name *</label>
                    <input type="text" class="form-control" name="pet_name" id="pet_name" value="{{ $appointment->pet_name }}" required style="width: 30%; border-radius: 10px;"/>
                </div>
                <div class="mb-3">
                    <label for="appointment_date" class="form-label">Appointment Date *</label>
                    <input type="date" class="form-control" name="appointment_date" id="appointment_date" value="{{ $appointment->appointment_date }}" required style="width: 30%; border-radius: 10px;"/>
                </div>
                <div class="mb-3">
                    <label for="appointment_type" class="form-label">Appointment Type *</label>
                    <select class="form-control" name="appointment_type" id="appointment_type" required style="width: 30%; border-radius: 10px;">
                        <option value="Check-Up" {{ $appointment->appointment_type == 'checkup' ? 'selected' : '' }}>Check-Up</option>
                        <option value="Grooming" {{ $appointment->appointment_type == 'grooming' ? 'selected' : '' }}>Grooming</option>
                        <option value="Vaccination" {{ $appointment->appointment_type == 'vaccination' ? 'selected' : '' }}>Vaccination</option>
                        <option value="Emergency" {{ $appointment->appointment_type == 'emergency' ? 'selected' : '' }}>Emergency</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="What is the appointment for?">{{ $appointment->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-control" name="status" id="status" required style="width: 30%; border-radius: 10px;">
                        <option value="Approved" {{ $appointment->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Denied" {{ $appointment->status == 'denied' ? 'selected' : '' }}>Denied</option>
                        <option value="Pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Update Appointment</button>
                </div>
            </form>
        </div>
    </div>
@endsection
