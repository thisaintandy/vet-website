<!-- resources\views\appointments\show.blade.php -->
@extends('layouts.adminnavigation')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Appointment Details') }}
    </h2>
@endsection

@section('content')
    <div class="container mx-auto mt-5 px-6 max-w-7xl sm:px-6 lg:px-8" style="padding-top: 7.5%">

        @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-5">
            {{ session('success') }}
        </div>
        @endif
        <div class="bg-gray-200 shadow-md rounded-lg p-6 max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
            <h3 class="text-xl font-bold mb-4"><b>Appointment ID: </b>{{ $appointment->appointment_id }}</h3>
            <p class="mb-2"><strong>Pet Name:</strong> {{ $appointment->pet_name }}</p>
            <p class="mb-2"><strong>Appointment Date:</strong> {{ $appointment->appointment_date }}</p>
            <p class="mb-2"><strong>Appointment Type:</strong> {{ $appointment->appointment_type }}</p>
            <p class="mb-2"><strong>Description:</strong> {{ $appointment->description }}</p>
            <p class="mb-2"><strong>Status:</strong> {{ $appointment->status }}</p>
        </div>

    </div>
@endsection
