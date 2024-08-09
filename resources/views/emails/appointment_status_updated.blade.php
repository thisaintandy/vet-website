<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Status Updated</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f4f7;
            font-family: Arial, sans-serif;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #007bff;
            padding: 15px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            text-align: center;
        }
        .email-header h2 {
            margin: 0;
            color: #ffffff;
        }
        .email-body {
            padding: 20px;
        }
        .email-footer {
            text-align: center;
            margin-top: 20px;
        }
        .btn-custom {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .badge-info {
            background-color: #17a2b8;
            color: #ffffff;
            padding: 5px 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Appointment Status Updated</h2>
        </div>
        <div class="email-body">
            <h4>Hello, {{ $user->name }}</h4>
            <p>Your appointment for your pet <strong>{{ $appointment->pet_name }}</strong> on <strong>{{ $appointment->appointment_date }}</strong> has been updated.</p>
            <p><strong>Status:</strong> <span class="badge badge-info">{{ $appointment->status }}</span></p>
            <p><strong>Description:</strong> {{ $appointment->description }}</p>
            <p class="text-muted">Thank you for using our service!</p>
        </div>
        <div class="email-footer">
            <a href="{{route('appointments.index')}}" class="btn btn-custom text-white">View Appointment</a>
        </div>
    </div>
</body>
</html>
