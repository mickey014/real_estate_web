<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
    <style>
        .bg {
            background-color: #ccc;
            padding: 5rem;
        }
        .container {
            background: #fff;
            padding: 3rem;
        }
        .reset-link {
            background: rgb(16, 172, 132);
            padding: .5rem;
            color: #fff !important;
            text-decoration: none;
            border-radius: 40px;
        }
        .link-text {
            text-decoration: none;
            color:rgb(34, 34, 34) !important;
        }

        @media(max-width: 400px) {
            .bg {
                padding: 2rem;
            }
            .container {
                background: #fff;
                padding: 1rem;
            }  
        }
    </style>
</head>
<body class="bg">
    
    <div class="container">
        <p>Hi, {{ $data['user'] }}.</p>
        <p>
            {{ $data['body'] }}
        </p>
        <a href="{{ $data['url'] }}" class="reset-link">Reset Password</a>
    
        <p>
            Or copy and paste the URL into your browser:<br/>
            <a class="link-text">{{ $data['url'] }}</a>
        </p>
        
        <p>If you didn't request a password reset, you can ignore this email. <br/> Your password will not be changed.</p>
        <p>
            Thank You, <br/>
            The {{ config('app.name') }} Team
        </p>
    </div>
    
    
</body>
</html>