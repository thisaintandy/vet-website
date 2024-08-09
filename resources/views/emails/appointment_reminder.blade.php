<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Reminder</title>
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
            background-color: #ffc107;
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
            background-color: #ffc107;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Appointment Reminder</h2>
        </div>
        <div class="email-body">
            <h4>Hello, {{ $user->name }}</h4>
            <p>This is a reminder that you have an upcoming appointment for your pet <strong>{{ $appointment->pet_name }}</strong> on <strong>{{ $appointment->appointment_date }}</strong>.</p>

            <p class="text-muted">Thank you for using our service!</p>
        </div>
        <div class="email-footer">
            <a href="{{route('appointments.index')}}" class="btn btn-custom">View Appointment</a>
        </div>
    </div>
</body>
</html>
