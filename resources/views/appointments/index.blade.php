<!-- resources\views\appointments\index.blade.php -->
@extends('layouts.navigation')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Your Appointments') }}
    </h2>
@endsection

@section('content')
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 bg-cover bg-center" style="background-image: url('/images/petdoctor.jpg'); height: 100px">
                    <h4 class="text-white"></h4>
                    <br>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto mt-5 px-6">
        @if(session('success'))
            <div class="bg-red-500 text-white p-4 rounded mb-5">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-5">
            <a href="" class="bg-green-500 text-white px-4 py-2 rounded">Create New Appointments</a>
        </div>

        @if (count($appointments) > 0)
            @foreach ($appointments as $item)
                @php
                    $bgColor = match($item->status) {
                        'Approved' => 'bg-green-100',
                        'Not Approved' => 'bg-pink-100',
                        'Pending' => 'bg-yellow-100',
                        default => 'bg-white',
                    };
                @endphp

                <div class="border border-blue-700 p-4 mb-3 rounded-lg flex justify-between items-center {{ $bgColor }}">
                    <div>
                        <p class="font-semibold">Appointment ID: {{ $item->appointment_id }}</p>
                        <p>Appointment Type: {{ $item->appointment_type }}</p>
                        <p>Pet Name: {{ $item->pet_name }}</p>
                        <p>Description: {{ $item->description }}</p>
                        <p>Date: {{ $item->appointment_date }}</p>
                        <p>Status: <b>{{ $item->status }}</b></p>
                    </div>
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('appointments.edit', ['id' => $item->appointment_id]) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit + </a>
                        <form action="{{ route('remove.from.appointments', ['id' => $item->appointment_id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div>
                <p>No items in cart!</p>
            </div>
        @endif
    </div>
@endsection