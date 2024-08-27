<?php 
include('functions.php');

// Initialize variables
$username = "";
$email = "";
$errors = array(); 

// Check if the form is submitted
if (isset($_POST['register_btn'])) {
    register();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://i.pinimg.com/originals/c2/af/2b/c2af2b98c6cffd1620759eac95f5135c.gif');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto; 
            max-height: 80vh; 
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 16px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        p {
            margin-top: 15px;
            text-align: center;
            color: #333;
        }
        .login-link {
            text-align: center;
            margin-top: 15px;
        }
        .login-link a {
            color: #007bff;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function showSuccessMessage() {
            alert("Registered successfully");
        }
    </script>
</head>
<body>
<div class="container">
    <form method="post" action="register.php" onsubmit="showSuccessMessage()">
        <?php echo display_error(); ?>
        <h2>Register</h2>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" name="password_confirm" required>
        </div>
        <div class="input-group">
            <label>Last Name:</label>
            <input type="text" name="last_name" required>
        </div>
        <div class="input-group">
            <label>First Name:</label>
            <input type="text" name="first_name" required>
        </div>
        <div class="input-group">
            <label>Maiden Name:</label>
            <input type="text" name="maiden_name">
        </div>
        <div class="input-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="input-group">
            <label>Gender:</label>
            <select name="gender" required>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
        </div>
        <div class="input-group">
            <label>Birthday:</label>
            <input type="date" name="birthday" required>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="register_btn">Register</button>
        </div>
        <p>Already a member? <a href="login.php">Sign in</a></p>
    </form>
</div>
</body>
</html>
