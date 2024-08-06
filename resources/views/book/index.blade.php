<!-- resources\views\appointments\index.blade.php -->
@extends('layouts.navigation')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight"><b>
        {{ __('Appointment Booking Form') }}</b>
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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-10">
            <form method="POST" action="{{ route('appointments.store') }}">
                @csrf
                @method('POST')
                <div class="mb-4">
                    <label for="pet_name" class="block text-gray-700 font-bold mb-2">Pet Name *</label>
                    <input type="text" class="w-1/3 p-2 border border-gray-300 rounded-lg" name="pet_name" id="pet_name" required />
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 font-bold mb-2">Appointment Date *</label>
                    <input type="date" class="w-1/3 p-2 border border-gray-300 rounded-lg" name="date" id="date" required />
                </div>
                <div class="mb-4">
                    <label for="appointment_type" class="block text-gray-700 font-bold mb-2">Appointment Type *</label>
                    <select class="w-1/3 p-2 border border-gray-300 rounded-lg" name="appointment_type" id="appointment_type" required>
                        <option value="" disabled selected>Select type</option>
                        <option value="checkup">Check-Up</option>
                        <option value="grooming">Grooming</option>
                        <option value="vaccination">Vaccination</option>
                        <option value="emergency">Emergency</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlTextarea1" class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea class="w-full p-2 border border-gray-300 rounded-lg" id="exampleFormControlTextarea1" name="description" rows="3" placeholder="What is the appointment for?"></textarea>
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Submit Request</button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-bold mb-4">How to Set a Veterinarian Appointment</h2>
            <ol class="list-decimal list-inside mb-4">
                <li class="mb-2"><strong>Visit the Appointment Booking Form:</strong> Navigate to the appointment booking page on our website.</li>
                <li class="mb-2"><strong>Enter Your Pet’s Information:</strong>
                    <ul class="list-disc list-inside ml-6">
                        <li class="mb-1"><strong>Pet Name:</strong> Enter the name of your pet in the provided field.</li>
                        <li class="mb-1"><strong>Appointment Date:</strong> Select the desired date for your appointment.</li>
                    </ul>
                </li>
                <li class="mb-2"><strong>Provide a Description:</strong> Use the description box to briefly explain the reason for the appointment.</li>
                <li class="mb-2"><strong>Review Your Appointment ID:</strong> Your unique Appointment ID will be automatically generated and displayed. This ID helps track your appointment.</li>
                <li class="mb-2"><strong>Submit Your Request:</strong> Click the "Submit Request" button to finalize your appointment.</li>
                <li class="mb-2"><strong>Confirmation:</strong> You will receive a confirmation of your appointment via email or on-screen message.</li>
            </ol>
            <p>If you have any questions or need further assistance, please contact our office.</p>
        </div>
    </div>
@endsection
