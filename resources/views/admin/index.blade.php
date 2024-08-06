@extends('layouts.adminnavigation')

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

    <div class="container mx-auto mt-0">
        <!-- Filter Form -->
        <form action="{{ route('admin.index') }}" method="GET" class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <div class="flex flex-col md:flex-row md:space-x-4">
                    <!-- Date Input -->
                    <input type="date" name="date" class="border border-gray-300 p-2 rounded mt-2 md:mt-0 w-full md:w-1/3 h-12" value="{{ request('date') }}" style="padding-top: 0.5rem; padding-bottom: 0.5rem;">

                    <!-- Pet Name Input -->
                    <input type="text" name="pet_name" class="border border-gray-300 p-2 rounded mt-2 md:mt-0 w-full md:w-1/3 h-12" value="{{ request('pet_name') }}" placeholder="Search Pet">

                    <!-- Status Select -->
                    <select name="status" class="border border-gray-300 p-2 rounded mt-2 md:mt-0 w-full md:w-1/3 h-12">
                        <option value="">All Statuses</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Denied" {{ request('status') == 'Denied' ? 'selected' : '' }}>Denied</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 md:mt-0 h-12">Filter</button>
            </div>
        </form>

        @if (count($appointments) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($appointments as $item)
                    @php
                        $bgColor = match($item->status) {
                            'Approved' => 'bg-green-100',
                            'Denied' => 'bg-pink-100',
                            'Pending' => 'bg-yellow-100',
                            default => 'bg-white',
                        };
                    @endphp

                    <div class="border border-blue-700 p-4 rounded-lg {{ $bgColor }} flex flex-col">
                        <p class="font-semibold">Appointment ID: {{ $item->appointment_id }}</p>
                        <p>Appointment Type: {{ $item->appointment_type }}</p>
                        <p>Pet Name: {{ $item->pet_name }}</p>
                        <p>Description: {{ $item->description }}</p>
                        <p>Date: {{ $item->appointment_date }}</p>
                        <p>Status: <b>{{ $item->status }}</b></p>
                        <div class="mt-auto flex flex-col space-y-2">
                            <a href="{{ route('admin.edit', ['id' => $item->appointment_id]) }}" class="bg-yellow-500 text-white px-4 py-2 rounded text-center">View +</a>
                            <form action="{{ route('remove.from.appointments', ['id' => $item->appointment_id]) }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div>
                <p>No appointments!</p>
            </div>
        @endif
    </div>
@endsection
