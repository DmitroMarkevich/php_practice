<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px 30px;
            max-width: 400px;
            text-align: center;
        }

        .container h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .token {
            background-color: #f0f0f0;
            border: 1px dashed #cccccc;
            padding: 10px 15px;
            border-radius: 5px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 16px;
            color: #555555;
            margin-top: 15px;
            display: inline-block;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #aaaaaa;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Email Confirmation</h1>
    <p>Please use the token below to confirm your email address:</p>
    <p class="token">${token}</p>
    <div class="footer">
        <p>&copy; 2025 Your Company. All rights reserved.</p>
    </div>
</div>
</body>
</html>
