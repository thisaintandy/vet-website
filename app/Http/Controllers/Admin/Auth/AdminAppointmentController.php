<?php

namespace App\Http\Controllers\Admin\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Appointments;
use Illuminate\Http\Request;
use App\Mail\AppointmentReminder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentStatusUpdated;


class AdminAppointmentController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all appointments or relevant data for listing
        $query = Appointments::query();

        // Apply filters
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->input('date'));
        }

        if ($request->filled('pet_name')) {
            $query->where('pet_name', $request->input('pet_name'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Get filtered appointments
        $appointments = $query->get();
        return view('admin.index', compact('appointments'));
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
    $userID = $appointment->user_id;
    $user = User::where('id', $userID)->first();

    // Pass the appointment and user data to the view
    return view('admin.show', compact('appointment', 'user'))
        ->with('success', 'Appointment updated successfully, and email notification sent to the user.');
}



public function removeFromAppointments(Request $request, $id)
    {

            $appointment = Appointments::where('appointment_id', $id)->first();
            if ($appointment) {
                $appointment->delete();
            }

            return redirect()->back()->with('success', 'Appointment removed successfully.');

    }

    public function edit($id)
    {
        $appointment = Appointments::where('appointment_id', $id)->first();
        $userID = $appointment->user_id;
        $user = User::where('id', $userID)->first();
        //dd($id, $userID, $user);
        return view('admin.edit', compact('appointment', 'user'));

    }

    public function update(Request $request, $id)
{
    // Validate the input data
    $validatedData = $request->validate([
        'pet_name' => 'required|string|max:255',
        'appointment_type' => 'required|string|max:255',
        'appointment_date' => 'required|date',
        'description' => 'nullable|string',
        'status' => 'required|string|max:255',
    ]);

    // Find the appointment record
    $appointment = Appointments::where('appointment_id', $id)->firstOrFail();

    // Update the appointment with validated data
    $appointment->pet_name = $validatedData['pet_name'];
    $appointment->appointment_type = $validatedData['appointment_type'];
    $appointment->appointment_date = $validatedData['appointment_date'];
    $appointment->description = $validatedData['description'];
    $appointment->status = $validatedData['status'];
    $appointment->save();

    // Get the user associated with this appointment (assuming a relationship exists)
    $user = $appointment->user;

    // Send an email to the user about the updated appointment status
    Mail::to($user->email)->send(new AppointmentStatusUpdated($appointment, $user));

    // Redirect back to the admin show page with a success message
    return redirect()->route('admin.show', ['id' => $id])
        ->with('success', 'Appointment updated successfully, and email notification sent to the user.');
}

    public function showAllUsers(Request $request)
    {
        // Retrieve all appointments or relevant data for listing
        $query = User::query();

        // Apply filters
        if ($request->filled('name')) {
            $query->where('name', $request->input('name'));
        }

        // Get filtered appointments
        $users = $query->get();

        return view('admin.allusers', compact('users'));
    }

    public function removeUser(Request $request, $id)
    {
        $user = User::where('email', $id)->first();

            if ($user) {
                $user->delete();
            }
            return redirect()->back()->with('success', 'User removed successfully.');
    }

    public function editUser(Request $request, $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        // Return the view with the appointment data
        return view('admin.editUser', compact('user'));
    }

    public function updateUser(Request $request, $id)
{
    $user = User::where('id', $id)->firstOrFail();
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone_number' => 'nullable|string|max:15',
    ]);

    // Fetch the user by ID
    $user = User::findOrFail($id);

    // Update user details
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->phone_number = $validatedData['phone_number'];
    $user->save();

    return redirect()->route('admin.allusers')
        ->with('success', 'User updated successfully.');
}


    public function notifyUser($id)
    {
        $appointment = Appointments::where('appointment_id', $id)->firstOrFail();
        $user = $appointment->user;

        if ($user) {
            // Calculate the remaining days
            $remainingDays = Carbon::parse($appointment->appointment_date)->diffInDays(Carbon::now(), false);

            // Prevent negative days
            if ($remainingDays < 0) {
                $remainingDaysMessage = "The appointment date has passed.";
            } else {
                $remainingDaysMessage = "$remainingDays days left until your appointment.";
            }

            // Send the email
            Mail::to($user->email)->send(new AppointmentReminder($appointment, $user, $remainingDaysMessage));

            return redirect()->route('admin.index')->with('success', 'Sent a reminder to user about the appointment!');
        }

        return redirect()->route('admin.index')->with('error', 'User not found.');
    }

}



