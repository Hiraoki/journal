<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You-Message</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://i.pinimg.com/originals/c2/af/2b/c2af2b98c6cffd1620759eac95f5135c.gif');
            color: #333;
            background-size: cover;
        }
        header {
            background-color: #282c34;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        header a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            margin: 0 15px;
            font-size: 16px;
        }
        header a:hover {
            text-decoration: underline;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 70px);
            text-align: center;
        }
        .welcome-message {
            max-width: 800px;
            margin: 0 auto;     
        }
        .welcome-message h1 {
            font-size: 3em;
            color: #28a745; /* Green color */
            margin: 0;
        }
        .welcome-message p {
            font-size: 1.2em;
            color: white;
            margin: 20px 0 0;
        }
    </style>
</head>
<body>
    <header>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </header>
    <div class="container">
        <div class="welcome-message">
            <h1>Welcome to <span style="color: #28a745;">Journal</span></h1>
            <p>Share your Day with Journal</p>
        </div>
    </div>
</body>
</html>
