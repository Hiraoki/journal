<?php include('functions.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('https://i.pinimg.com/originals/c2/af/2b/c2af2b98c6cffd1620759eac95f5135c.gif');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            width: 400px; 
        }
        .login-container h2 {
            text-align: center;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }
        .login-container input[type="submit"] {
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            outline: none;
            cursor: pointer;
            background-color: #28a745;
            color: #fff;
        }
        .login-container input[type="submit"]:hover {
            background-color: #218838; 
        }
        .login-container input[type="checkbox"] {
            margin-bottom: 10px;
            transform: scale(1.5);
        }
        .robot-check-label {
            font-size: 20px; 
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <?php echo display_error(); ?>
    <form action="login.php" method="POST" onsubmit="return validateForm()">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <label class="robot-check-label">
            I'm not a robot
            <input type="checkbox" id="robot_check" name="robot_check">
        </label>
        <input type="submit" name="login_btn" value="Login">
        <p>
            <a href="register.php" style="display: block; text-align: center;">Sign up</a>
        </p>
    </form>
</div>

<script>
    function validateForm() {
        var checkBox = document.getElementById("robot_check");
        if (!checkBox.checked) {
            alert("Please confirm that you're not a robot.");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
