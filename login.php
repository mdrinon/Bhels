<?php
// Enable error reporting
error_reporting(E_ALL);

// Include MongoDB library
require 'vendor/autoload.php'; // Ensure MongoDB library is autoloaded via Composer

// Connect to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->bheldb->accounts;

$message = '';
$message_type = ''; // success or error

// Check if 'accounts' collection exists
$collections = $client->bheldb->listCollections(['filter' => ['name' => 'accounts']]);
$collectionsArray = iterator_to_array($collections);

if (!empty($collectionsArray)) {
    // $message = "Accounts collection exists.";
    $message_type = 'success';
} else {
    $message = "Accounts collection doesn't exist. Creating it...";
    $message_type = 'error';
    // If needed, create the collection
    $collection->insertOne(['dummy' => 'dummy']);
    $collection->deleteOne(['dummy' => 'dummy']);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_input = htmlspecialchars($_POST['phone_email']);
    $password = htmlspecialchars($_POST['password']);

    // Special case for 'developer' user
    if ($login_input === 'developer' && $password === 'Sep292002') {
        // Start session and store user details
        session_start();
        $_SESSION['username'] = 'developer';
        $_SESSION['firstname'] = 'Mark';
        $_SESSION['lastname'] = 'Riñon';

        // Display choice pop-up for 'developer'
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                const choicePopup = document.createElement("div");
                choicePopup.id = "choice-popup";
                choicePopup.innerHTML = `
                    <div class="popup-content">
                        <span class="close-btn" onclick="closeChoicePopup()">&times;</span>
                        <p>Login as:</p>
                        <button onclick="redirectTo(\'Home.php\')">User</button>
                        <button onclick="redirectTo(\'ADMIN/index.php\')">Admin</button>
                    </div>
            <style>
                #choice-popup {
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: #ffffff;
                    padding: 40px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    z-index: 1000;
                    border-radius: 20px;
                }
                #choice-popup .popup-content {
                    text-align: center;
                    color: black;
                    font-family: arial, sans-serif;
                    font-size: 1.5rem;
                }
                #choice-popup .popup-content p {
                    margin: 20px 0;
                }
                #choice-popup button {
                    padding: 10px 20px;
                    cursor: pointer;
                    border: none;
                    background: #cb5584;
                    color: #fff;
                    border-radius: 5px;
                }
                button:hover {
                    background: #c64581;
                    transform: scale(1.05);
                }
                .close-btn {
                    position: absolute;
                    top: 20px;
                    right: 25px;
                    cursor: pointer;
                    font-size: 1.5rem;
                    color: #000;
                }
                .close-btn:hover {
                    color: #cb5584;
                }
            </style>`;
                document.body.appendChild(choicePopup);
            });

            function redirectTo(url) {
                if (url === "home.php") {
                    document.getElementById("user-redirect-form").submit();
                } else {
                    window.location.href = url;
                }
            }

            function closeChoicePopup() {
                // Destroy session and redirect to login form
                fetch("logout.php").then(() => {
                    window.location.href = "login.php";
                });
            }
                
        </script>';
        exit();
    }

    // Find the user in the database by username, email, or phone
    $user = $collection->findOne([
        '$or' => [
            ['username' => $login_input],
            ['phone' => $login_input],
            ['email' => $login_input]
        ]
    ]);

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Successful login
            $message = "Login successful! Redirecting...";
            $message_type = 'success';

            // Start session and store user details
            session_start();
            $_SESSION['user_id'] = (string) $user['_id']; // Store user ID in session
            $_SESSION['username'] = $user['username']; 
            $_SESSION['firstname'] = $user['firstname']; // Store firstname in session
            $_SESSION['lastname'] = $user['lastname'];   // Store lastname in session
            $_SESSION['email'] = $user['email'];         // Store email in session
            $_SESSION['phone'] = $user['phone'];         // Store phone in session

            // Debugging code to check session variables
            error_log("Session Phone: " . $_SESSION['phone']);
            error_log("Session Email: " . $_SESSION['email']);

            // Redirect to the main page after a short delay
            header("refresh:2;url=home.php");
            exit();
        } else {
            // Incorrect password
            $message = "Incorrect password. Please try again.";
            $message_type = 'error';
        }
    } else {
        // User not found
        $message = "No account found with this username, phone number, or email.";
        $message_type = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signin.css">
    <title>Login</title>
</head>
<body>

    <section id="login-form">
      <form class="form" action="login.php" method="POST">
        <p class="title">Login</p>
        <label>
          <input class="input" type="text" name="phone_email" placeholder="" required>
          <span>Username / Phone Number / Email</span>
        </label>
        <label>
          <input class="input" type="password" name="password" id="password" placeholder="" required>
          <span>Password</span>
        </label>
        <!-- Show Password Toggle -->
        <label>
          <input type="checkbox" onclick="togglePasswordVisibility()"> Show Password
        </label>
        <button class="submit" type="submit">Login</button>
        <p class="signin">Don't have an account? <a href="signup.php">Register</a></p>
      </form>
      <div id="message-container"></div> <!-- Container for messages -->
    </section>

    <!-- Hidden form for user redirection -->
    <form id="user-redirect-form" action="home.php" method="POST" style="display: none;">
        <input type="hidden" name="username" value="developer">
    </form>

    <!-- Pop-up message HTML -->
    <div id="popup-message" class="popup-message <?php echo $message_type; ?>">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <div class="message-content"><?php echo $message; ?></div>
    </div>

    <script>
        function closePopup() {
            document.getElementById('popup-message').style.display = 'none';
        }

        // Show pop-up message if there is a message
        const message = "<?php echo $message; ?>";
        const messageType = "<?php echo $message_type; ?>";

        if (message) {
            const popup = document.getElementById('popup-message');
            popup.style.display = 'block';
            
            if (messageType === 'success') {
                // Auto-hide success message after 4 seconds
                setTimeout(() => {
                    popup.style.display = 'none';
                }, 4000);
            }
        }
    
        // Toggle password visibility
        function togglePasswordVisibility() {
            const passwordField = document.getElementById("password");
            const passwordType = passwordField.type === "password" ? "text" : "password";
            passwordField.type = passwordType;
        }
    </script>
</body>
</html>
