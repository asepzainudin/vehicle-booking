<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Email Credential</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
            color: #51545e;
        }

        a {
            color: #3869d4;
            text-decoration: none;
        }

        .email-wrapper {
            width: 100%;
            background-color: #f4f4f7;
            padding: 20px;
        }

        .email-content {
            background-color: #ffffff;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
        }

        .email-header {
            text-align: center;
            padding-bottom: 20px;
        }

        .email-header img {
            width: 100px;
        }

        .email-body {
            padding: 20px 0;
            border-top: 1px solid #eaeaea;
        }

        .email-body h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .email-body p {
            font-size: 16px;
            color: #51545e;
            margin-bottom: 20px;
        }

        /* Table Styles */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 10px;
            border: 1px solid #eaeaea;
            text-align: left;
            font-size: 14px;
        }

        .invoice-table th {
            background-color: #f4f4f7;
            font-weight: bold;
        }

        .invoice-total {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
        }

        .button {
            background-color: #3869d4;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
        }

        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6b6e76;
        }

        .email-footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <!-- Header -->
            {{-- <div class="email-header">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('path-to-your-logo/logo.png') }}" alt="Logo">
                </a>
            </div> --}}

            <!-- Body -->
            <div class="email-body">
                <h1>Credential Login gaido app</h1>
                <h3>Email :</h3>
                <p>{{ $user['email'] ?? '' }}</p>
                <h3>Password : </h3>
                <p>{{ $user['password'] ?? '' }}</p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
