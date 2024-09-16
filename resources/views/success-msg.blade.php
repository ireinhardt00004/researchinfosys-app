<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Successful Registration</title>
    <script src="https://kit.fontawesome.com/fe516ea130.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .error-container {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
        }

        .logo-container {
            color: #333;
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            font-size: 1.1em;
            margin-top: 15px;
        }

        .home-link {
            text-decoration: none;
            color: #fff;
            background-color: #1b651b;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
        }

        .icon-check {
            color: green;
            font-size: 3em;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="error-container">
        <div class="logo-container">
            {{-- <a href="/" title="Return to Homepage">
                <img style="width: 80px; height: 85px;" src="{{ asset('assets/head_logo/' . ($generalConfig->logo ?? 'default-logo.png')) }}" alt="logo">
            </a> --}}
            <h5 style="font-weight: bold;" class="mb-4">{{ config('app.name', '') }}</h5>
        </div>
        
        <i class="fas fa-check-circle icon-check"></i>
        <h1>Registration Successful!</h1>
        <p>You will receive an email notification once your account is verified by our staff.<br>
           Click the button below to return to the homepage.</p>
        <a href="/" class="home-link">Go to Homepage</a>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
