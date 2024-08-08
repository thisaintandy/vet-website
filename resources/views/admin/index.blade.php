@extends('layouts.adminnavigation')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Your Appointments') }}
    </h2>
@endsection

@section('content')
    <div class="pt-3" style="margin-top: 7.5%">
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
        <!-- Filter Form -->
        <form action="{{ route('admin.index') }}" method="GET" class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
                <div class="flex flex-col md:flex-row md:space-x-4">
                    <!-- Date Input -->
                    <input type="date" name="date" class="border border-gray-300 p-2 rounded mt-2 md:mt-0 w-full md:w-1/4 h-12" value="{{ request('date') }}" style="padding-top: 0.5rem; padding-bottom: 0.5rem;">

                    <!-- Pet Name Input -->
                    <input type="text" name="pet_name" class="border border-gray-300 p-2 rounded mt-2 md:mt-0 w-full md:w-1/4 h-12" value="{{ request('pet_name') }}" placeholder="Search Pet">

                    <!-- Status Select -->
                    <select name="status" class="border border-gray-300 p-2 rounded mt-2 md:mt-0 w-full md:w-1/4 h-12">
                        <option value="">All Statuses</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Denied" {{ request('status') == 'Denied' ? 'selected' : '' }}>Denied</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                    <button type="submit" class="border text-white bg-gray-500 p-2 rounded mt-2 md:mt-0 w-full md:w-1/4 h-12">Filter</button>
                </div>

            </div>
        </form>


        @if (count($appointments) > 0)
            <div class="flex flex-wrap -mx-10">
                @foreach ($appointments as $item)
                    @php
                        $bgColor = match($item->status) {
                            'Approved' => 'bg-green-100',
                            'Denied' => 'bg-pink-100',
                            'Pending' => 'bg-yellow-100',
                            default => 'bg-white',
                        };
                    @endphp

                    <div class="w-full md:w-1/2 xl:w-1/2 p-4">
                        <div class="border mb-3 rounded-lg">
                            <div class="border p-4 mb-3 rounded-lg flex justify-between items-center {{ $bgColor }}">
                                <p class="font-semibold">Appointment ID: {{ $item->appointment_id }}</p>
                                <p>Date: {{ $item->appointment_date }}</p>
                            </div>
                            <div class="p-4 mb-3 rounded-lg flex justify-between items-center">
                                <div>
                                    <p>Status: <b>{{ $item->status }}</b></p>
                                    <p>Appointment Type: {{ $item->appointment_type }}</p>
                                    <p>Pet Name: {{ $item->pet_name }}</p>
                                </div>

                                <div class="flex flex-col space-y-2">
                                    <a href="{{ route('admin.edit', ['id' => $item->appointment_id]) }}" class="bg-gray-600 text-white px-4 py-2 rounded text-center">View +</a>
                                    <form action="{{ route('remove.from.appointments', ['id' => $item->appointment_id]) }}" method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </div>
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
