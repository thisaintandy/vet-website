<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\NotifyApproval;

class Notification extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        dd($id);
        $appointment = Appointments::where('appointment_id', $id)->first();
        $userID = $appointment->user_id;
        $user = User::where('id', $userID)->first();

        $messages["hi"] = "Hey, {$user->name}";
        $messages["wish"] = "Thank you for having interest in scheduling an appointment to our clinic. Below is the status of your appointment. ";

        $user->notify(new NotifyApproval($messages));

        dd('Done');
    }
}
