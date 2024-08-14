<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Fetch appointments based on user ID
        $appointments = Appointments::where('user_id', $userId)->get();

        // Prepare event data for FullCalendar
        $eventData = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->description,
                'start' => $appointment->appointment_date . 'T00:00:00',
                'end' => $appointment->appointment_date . 'T23:59:59',
            ];
        });

        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'appointments' => $appointments,
                'eventData' => $eventData,
            ]);
        }
        
        // Return the view with appointments and eventData
        return view('full_calendar', [
            'appointments' => $appointments,
            'eventData' => $eventData
        ]);
    }


public function getEvents(Request $request)
{
    $userId = Auth::id();
    $appointments = Appointments::where('user_id', $userId)->get();
    $eventData = $appointments->map(function ($event) {
        return [
            'id' => $event->id,
            'title' => $event->description,
            'start' => $event->appointment_date . 'T00:00:00',
            'end' => $event->appointment_date . 'T23:59:59',
        ];
    });
    return response()->json($eventData);
}

public function ajax(Request $request)
{
    $validatedData = $request->validate([
        'pet_name' => 'required|string|max:255',
        'start' => 'required|date',
        'appointment_type' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|string|in:add,update',
        'id' => 'nullable|integer',
    ]);

    switch ($request->type) {
        case 'add':
            $today = now()->format('Ymd');
            $increment = 1;

            // Find the last appointment ID for today and calculate the next increment
            $latestAppointment = Appointments::whereDate('created_at', today())
                                             ->orderBy('created_at', 'desc')
                                             ->first();
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

            // Create the appointment
            $event = new Appointments;
            $event->user_id = Auth::id();
            $event->pet_name = $request->pet_name;
            $event->appointment_type = $request->appointment_type;
            $event->description = $request->description;
            $event->status = 'Pending';
            $event->appointment_date = $request->start;
            $event->appointment_id = $appointmentId; // Set the generated appointment ID
            $event->save();

            return response()->json(['id' => $event->id]);

        case 'update':
            $event = Appointments::find($request->id);
            if ($event) {
                $event->appointment_date = $request->start;
                $event->save();
                return response()->json(['status' => 'Event updated']);
            } else {
                return response()->json(['status' => 'Event not found'], 404);
            }

        default:
            return response()->json(['status' => 'Invalid request'], 400);
    }
}



}

