<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Appointments;
use Illuminate\Http\Request;
use App\Models\ProductsInCart;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;


class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all appointments or relevant data for listing
        $query = Appointments::query();
        $userId = Auth::id();
            $user = User::findOrFail($userId);
            $appointments = Appointments::where('user_id', $userId)->get();

        if ($request->filled('user')) {
            $query->where('user_id', $request->input('user'));
        }
        return view('appointments.index', compact('appointments'));

    }

    public function bookAppointment()
    {
        // Retrieve all appointments or relevant data for listing
        $appointments = Appointments::all();
        return view('book.index', compact('appointments'));
    }



    // Method for adding an appointment
    public function addAppointment(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'appointment_id' => 'required|string|unique:appointments',
            'user_id' => 'required|exists:users,id',
            'pet_name' => 'required|string|max:255',
            'appointment_type' => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        // Create a new appointment entry
        $appointment = new Appointments();
        $appointment->appointment_id = $validatedData['appointment_id'];
        $appointment->user_id = $validatedData['user_id'];
        $appointment->pet_name = $validatedData['pet_name'];
        $appointment->appointment_type = $validatedData['appointment_type'];
        $appointment->appointment_date = $validatedData['appointment_date'];
        $appointment->description = $validatedData['description'];
        $appointment->save();

        return redirect()->back()->with('success', 'Appointment added successfully.');
    }

    // Method for handling form submission
    public function store(Request $request)
{
    // Validate the request
    $validatedData = $request->validate([
        'pet_name' => 'required|string|max:255',
        'date' => 'required|date',
        'appointment_type' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    // Generate a unique appointment ID
    $today = now()->format('Ymd');
    $increment = 1;

    // Find the last appointment ID for today and calculate the next increment
    $latestAppointment = Appointments::whereDate('created_at', today())->orderBy('created_at', 'desc')->first();
    if ($latestAppointment) {
        $lastId = $latestAppointment->appointment_id;
        $lastIncrement = intval(substr($lastId, -2));
        $increment = $lastIncrement + 1;
    }

    // Format the appointment ID with leading zeros
    $appointmentId = "VA-{$today}-" . str_pad($increment, 2, '0', STR_PAD_LEFT);

    // Ensure the ID is unique
    while (Appointments::where('appointment_id', $appointmentId)->exists()) {
        $increment++;
        $appointmentId = "VA-{$today}-" . str_pad($increment, 2, '0', STR_PAD_LEFT);
    }



    // Create a new appointment entry
    $appointment = new Appointments();
    $appointment->appointment_id = $appointmentId;
    $appointment->user_id = Auth::id();
    $appointment->pet_name = $validatedData['pet_name'];
    $appointment->appointment_type = $validatedData['appointment_type'];
    $appointment->appointment_date = $validatedData['date'];
    $appointment->description = $validatedData['description'];
    $appointment->status = 'Pending';
    $appointment->save();

    return redirect()->route('appointments.show', ['id' => $appointmentId])->with('success', 'Appointment booked successfully.');
}



    public function show($id)
    {
        // Retrieve the appointment using the custom ID
        $appointment = Appointments::where('appointment_id', $id)->firstOrFail();
        $userId = Auth::id();
            $user = User::findOrFail($userId);
            $appointments = Appointments::where('user_id', $userId)->get();

            // Debug output
        // dd($user, $appointments);

        // Pass the appointment data to the view
        return view('appointments.show', compact('appointment', 'user'));
    }

    public function removeFromAppointments(Request $request, $id)
        {

                $appointment = Appointments::where('appointment_id', $id)->first();
                if ($appointment) {
                    $appointment->delete();
                }

                return redirect()->back()->with('success', 'Item removed from cart.');

    }

    public function edit($id)
    {
        // Find the authenticated user
        $user = User::findOrFail(Auth::id());

        // Find the appointment with the given id and user_id
        $appointment = Appointments::where('appointment_id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Return the view with the appointment data
        return view('appointments.edit', compact('appointment', 'user'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'pet_name' => 'required|string|max:255',
            'appointment_type' => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $appointment = Appointments::where('appointment_id', $id)->where('user_id', Auth::id())->firstOrFail();
        $appointment->pet_name = $validatedData['pet_name'];
        $appointment->appointment_type = $validatedData['appointment_type'];
        $appointment->appointment_date = $validatedData['appointment_date'];
        $appointment->description = $validatedData['description'];
        $appointment->save();

        return redirect()->route('appointments.show', ['id' => $id])
            ->with('success', 'Appointment updated successfully.');
    }
}



