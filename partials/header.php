<?php
session_start(); // Start the session at the beginning of the file

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit(); // Always exit after sending a header to avoid further code execution
}

// User is logged in, set variables for their full name, username, user ID, phone, and email.
$fullname = htmlspecialchars($_SESSION['firstname']) . ' ' . htmlspecialchars($_SESSION['lastname']);
$username = htmlspecialchars($_SESSION['username']);
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Safely extract user ID
$phone = isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : '';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '';

// Debugging code to check session variables
error_log("Session Phone: " . $phone);
error_log("Session Email: " . $email);

// Include the database connection after session checks
include('dbconnect.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>keyk</title>
    <link rel="icon" type="image/png" href="images/svg/LogosCakephpIcon.png">

    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script src="javascript/jquery-3.5.1.min.js"></script>

    <!-- CSS AND SCRIPT FOR SLIDING SCALE ON FILTER OPTION -->
    <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="javascript/jquery-1.12.4.js"></script>
    <script src="javascript/jquery-ui.js"></script>

    <link rel="stylesheet" href="https://cdn.plyr.io/3.6.8/plyr.css" />
    <!-- <link rel="stylesheet" type="text/css" href="css/plyr.css"> -->
     
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<!-- <div class="page-loader">
    <div class="progress"></div>
        <p class="fs-7 fw-600 txt-dark">We are loading things up.</p>
    </div>
</div> -->

<script>
    function clearStorage() {
        sessionStorage.clear();
        localStorage.clear();
    }
</script>