<?php
session_start();
session_unset();
session_destroy();
header("Location: ../login.php"); // Replace with the desired page after logout
exit;
?>
