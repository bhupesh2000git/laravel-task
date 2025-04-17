<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Landing Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
        }

        h1 {
            margin-bottom: 30px;
            font-size: 24px;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .buttons a {
            text-decoration: none;
            background-color: #4A90E2;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .buttons a:hover {
            background-color: #357ABD;
        }

        @media (min-width: 600px) {
            .buttons {
                flex-direction: row;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to Task Details:</h1>
        <div class="buttons">
            <a href="{{ route('indeximage') }}">Upload Image</a>
            <a href="{{ route('array-sum') }}">Sum Number</a>
            <a href="{{ route('ksort-number') }}">Find K Closest Elements</a>
        </div>
    </div>
</body>

</html>