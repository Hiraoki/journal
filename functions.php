<?php
session_start(); // Ensure session handling is enabled

// Database connection
$db = new mysqli('localhost', 'root', 'Jlawrence#25', 'journal');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Initialize variables
$username = "";
$email    = "";
$errors   = array(); 

// Registration function
function register() {
    global $db, $errors;

    // Sanitize and validate input data
    $username = $db->real_escape_string($_POST['username']);
    $email = $db->real_escape_string($_POST['email']);
    $password_1 = $_POST['password'];
    $password_2 = $_POST['password_confirm'];
    $last_name = $db->real_escape_string($_POST['last_name']);
    $first_name = $db->real_escape_string($_POST['first_name']);
    $maiden_name = $db->real_escape_string($_POST['maiden_name']);
    $gender = $db->real_escape_string($_POST['gender']);
    $birthday = $db->real_escape_string($_POST['birthday']);

    // Validate input
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) { array_push($errors, "The two passwords do not match"); }

    // Check if there are no errors
    if (count($errors) == 0) {
        // Encrypt the password using password_hash
        $password = password_hash($password_1, PASSWORD_DEFAULT);

        // SQL query to insert data
        $query = $db->prepare("INSERT INTO information (username, email, password, last_name, first_name, maiden_name, gender, birthday) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param('ssssssss', $username, $email, $password, $last_name, $first_name, $maiden_name, $gender, $birthday);

        if ($query->execute()) {
            $_SESSION['success'] = "New user successfully created!!";
            header('Location: login.php');
            exit();
        } else {
            array_push($errors, "Error: " . $query->error);
        }
    }
}

// Function to display errors
function display_error() {
    global $errors;

    if (count($errors) > 0) {
        echo '<div class="error">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
}
function isLoggedIn() {
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

function getUserById($id){
    global $db;
    $query = "SELECT * FROM information WHERE id=" . $id;
    $result = mysqli_query($db, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}

if (isset($_POST['login_btn'])) {
    login();
}

// Login function
function login() {
    global $db, $errors;

    // Sanitize and validate user input
    $username = $db->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        // Prepare and execute the SQL query
        $query = $db->prepare("SELECT * FROM information WHERE username = ? LIMIT 1");
        if (!$query) {
            array_push($errors, "SQL prepare error: " . $db->error);
            return;
        }

        $query->bind_param('s', $username);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows == 1) {
            $logged_in_user = $result->fetch_assoc();

            // Check password using password_verify
            if (password_verify($password, $logged_in_user['password'])) {
                $_SESSION['user'] = $logged_in_user;
                $_SESSION['success'] = "You are now logged in";
                header('Location: journal.php'); // Redirect to youmessage.php
                exit();
            } else {
                array_push($errors, "Wrong username/password combination");
            }
        } else {
            array_push($errors, "User not found");
        }
    }
}

// Admin authentication
$admin_username = "admin";
$admin_password = "123456";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION["admin"] = true;
        header("Location: journal.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}

?>
