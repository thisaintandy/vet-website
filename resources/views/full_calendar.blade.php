@extends('layouts.navigation')

@section('content')
    <div class="container mt-5" style="margin-left:10%;">
        <div class="d-flex" style="width: 130%">
            <!-- Calendar Section -->
            <div id="calendar" class="flex-grow-1" style="height: 80%; margin-top: 5%"></div>

            <!-- Appointments Section -->
            <div class="flex-shrink-0" style="width: 40%; margin-left: 20px; margin-top: 5%;">
                <div class="mb-4 mt-3">
                    <a href="{{ route('book.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Create New Appointments</a>
                </div>

                @if(session('success'))
                    <div class="bg-red-500 text-white p-4 rounded mb-2">
                        {{ session('success') }}
                    </div>
                @endif

                @if (count($appointments) > 0)
                    @foreach ($appointments as $item)
                        @php
                            $bgColor = match($item->status) {
                                'Approved' => '#d1e7dd',
                                'Denied' => '#f8d7da',
                                'Pending' => '#f0ad4e',
                                default => '#f0ad4e',
                            };
                        @endphp
                        <div class="border border-gray-300 mb-4 rounded-lg shadow-md">
                            <div class="bg-gray-100 p-4 rounded-t-lg flex justify-between items-center" style="background-color: {{ $bgColor }};">
                                <p class="font-semibold text-lg">Appointment ID: {{ $item->appointment_id }}</p>
                                <p class="text-sm text-gray-600">Date: {{ $item->appointment_date }}</p>
                            </div>
                            <div class="p-4">
                                <div class="mb-2">
                                    <p class="text-md font-medium">Pet Name: <span class="font-normal">{{ $item->pet_name }}</span></p>
                                    <p class="text-md font-medium">Status: <span class="font-bold text-{{ $item->status == 'Approved' ? 'green' : ($item->status == 'Denied' ? 'red' : 'orange') }}-600">{{ $item->status }}</span></p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('appointments.edit', ['id' => $item->appointment_id]) }}" class="bg-blue-600 text-white px-4 py-2 rounded text-center hover:bg-blue-700 transition duration-200 w-24">Edit</a>
                                    <form action="{{ route('remove.appointment', ['id' => $item->appointment_id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this appointment?');">
                                        @csrf
                                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded text-center hover:bg-red-700 transition duration-200 w-24">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>



                    @endforeach
                @else
                    <div>
                        <p>No appointment/s requested!</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal for Creating Appointments -->
        <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentModalLabel">Create Appointment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="appointmentForm">
                            <div class="form-group">
                                <label for="title">Event Title</label>
                                <input type="text" class="form-control" id="title" placeholder="Enter event title" required>
                            </div>
                            <div class="form-group">
                                <label for="pet_name">Pet Name</label>
                                <input type="text" class="form-control" id="pet_name" placeholder="Enter pet name" required>
                            </div>
                            <div class="form-group">
                                <label for="appointment_type">Appointment Type</label><br>
                                <select class="w-1/3 p-2 border border-gray-300 rounded-lg" name="appointment_type" id="appointment_type" required>
                                    <option value="" disabled selected>Select type</option>
                                    <option value="checkup">Check-Up</option>
                                    <option value="grooming">Grooming</option>
                                    <option value="vaccination">Vaccination</option>
                                    <option value="emergency">Emergency</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Enter description"></textarea>
                            </div>
                            <input type="hidden" id="start">
                            <input type="hidden" id="end">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="saveAppointment">Save Appointment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
    var SITEURL = "{{ url('/') }}";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#calendar').fullCalendar({
        editable: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: function(start, end, timezone, callback) {
            $.ajax({
                url: SITEURL + '/full-calendar-events',
                type: 'GET',
                success: function(events) {
                    callback(events);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching events:', xhr.responseText);
                }
            });
        },
        selectable: true,
        selectHelper: true,
        select: function(start, end) {
            $('#start').val($.fullCalendar.formatDate(start, "Y-MM-DD"));
            $('#end').val($.fullCalendar.formatDate(end, "Y-MM-DD"));
            $('#appointmentModal').modal('show');
        },
        eventDrop: function(event) {
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

            $.ajax({
                url: SITEURL + '/full-calendar-ajax',
                data: {
                    title: event.title,
                    start: start,
                    end: end,
                    id: event.id,
                    type: 'update'
                },
                type: "POST",
                success: function() {
                    displayMessage("Event Updated Successfully");
                },
                error: function(xhr, status, error) {
                    console.error('Error updating event:', xhr.responseText);
                }
            });
        }
    });

    $('#saveAppointment').on('click', function() {
        var title = $('#title').val();
        var pet_name = $('#pet_name').val();
        var appointment_type = $('#appointment_type').val();
        var description = $('#description').val();
        var start = $('#start').val() + 'T00:00:00';
        var end = $('#end').val() + 'T23:59:59';

        $.ajax({
            url: SITEURL + "/full-calendar-ajax",
            data: {
                title: title,
                pet_name: pet_name,
                appointment_type: appointment_type,
                description: description,
                start: start,
                end: end,
                type: 'add'
            },
            type: "POST",
            success: function(data) {
                console.log('Success:', data);
                displayMessage("Event Created Successfully");
                $('#appointmentModal').modal('hide');
                $('#calendar').fullCalendar('refetchEvents'); // Refresh events to include the new appointment
            },
            error: function(xhr, status, error) {
                console.error('Error creating event:', xhr.responseText);
            }
        });
    });

    function displayMessage(message) {
        toastr.success(message, 'Event');
    }
});
</script>
@endsection
