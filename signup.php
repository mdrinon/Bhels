<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/signin.css">
  <title>Register</title>
</head>
<body>
  <div id="register-form">
    <form class="form" action="signup.php" method="POST">
      <p class="title">Register</p>
      <div class="Full_name" style="display: flex; gap: 10px">
        <label style="width: 100%">
            <input class="input" type="text" name="username" required>
            <span>Username</span>
        </label>
        <label>
            <select style="width: 100px" class="input" name="gender" required>
            <option value="" disabled selected>   </option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            </select>
            <span>Gender</span>
        </label>
      </div>
      <div class="Full_name" style="display: flex; gap: 10px">    
        <label>
            <input class="input" type="text" name="firstname" required>
            <span>Firstname</span>
        </label>
        <label>
            <input class="input" type="text" name="lastname" required>
            <span>Lastname</span>
        </label>
      </div>
      <label>
        <input class="input" type="text" name="phone" required>
        <span>Phone Number</span>
      </label>
      <label>
        <input class="input" type="text" name="email">
        <span>Email (Optional)</span>
      </label>
      <label>
        <input class="input" type="password" name="password" id="password" required>
        <span>Password</span>
      </label>
      <label>
        <input class="input" type="password" name="confirm_password" id="confirm_password" required>
        <span>Confirm Password</span>
      </label>
      <!-- Show Password Toggle -->
      <label>
        <input type="checkbox" onclick="togglePasswordVisibility()"> Show Password
      </label>
      <button class="submit" type="submit">Register</button>
      <p class="signin">Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>

  <!-- Pop-up message HTML -->
  <div id="popup-message" class="popup-message">
      <span class="close-btn" onclick="closePopup()">&times;</span>
      <div class="message-content"></div>
  </div>

  <!-- Ensure showMessage is available before PHP script uses it -->
  <script>
    function showMessage(type, message) {
        const popup = document.getElementById('popup-message');
        const messageContent = popup.querySelector('.message-content');

        // Set message type
        popup.className = 'popup-message ' + type;
        messageContent.textContent = message;
        popup.style.display = 'block';

        if (type === 'success') {
            // Automatically hide success message after 4 seconds
            setTimeout(() => {
                popup.style.display = 'none';
            }, 4000);
        }
    }

    function closePopup() {
        document.getElementById('popup-message').style.display = 'none';
    }

    // show password
    function togglePasswordVisibility() {
      const passwordField = document.getElementById("password");
      const confirmPasswordField = document.getElementById("confirm_password");
      const passwordType = passwordField.type === "password" ? "text" : "password";
      passwordField.type = passwordType;
      confirmPasswordField.type = passwordType;
    }
  </script>

  <?php
  // Enable error reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // Include MongoDB library
  require 'vendor/autoload.php';

  // Connect to MongoDB
  $client = new MongoDB\Client("mongodb://localhost:27017");
  $collection = $client->bheldb->accounts;

  // Check if 'accounts' collection exists
  $collectionExists = false;
  foreach ($client->bheldb->listCollections() as $collectionInfo) {
      if ($collectionInfo->getName() === 'accounts') {
          $collectionExists = true;
          break;
      }
  }

  if (!$collectionExists) {
      // Insert dummy document to create the collection
      $collection->insertOne(['dummy' => 'dummy']);
      $collection->deleteOne(['dummy' => 'dummy']);
  }

  // Function to validate phone number
  function validatePhone($input) {
      return preg_match('/^09\d{9}$/', $input) || preg_match('/^9\d{9}$/', $input);
  }

  // Function to check password strength
  function validatePasswordStrength($password) {
      return strlen($password) >= 8 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = htmlspecialchars($_POST['username']);
      $firstname = htmlspecialchars($_POST['firstname']);
      $lastname = htmlspecialchars($_POST['lastname']);
      $phone = htmlspecialchars($_POST['phone']);
      $email = htmlspecialchars($_POST['email'] ?? '');
      $gender = htmlspecialchars($_POST['gender']);
      $password = htmlspecialchars($_POST['password']);
      $confirm_password = htmlspecialchars($_POST['confirm_password']);

      // Validate phone input
      if (!validatePhone($phone)) {
          echo "<script>
              window.onload = function() {
                  showMessage('error', 'Invalid phone number format.');
              };
          </script>";
          exit;
      }

      // Ensure phone number starts with '09'
      if (strpos($phone, '9') === 0) {
          $phone = '0' . $phone;
      }

      // Validate password and confirm password match
      if ($password !== $confirm_password) {
          echo "<script>
              window.onload = function() {
                  showMessage('error', 'Passwords do not match.');
              };
          </script>";
          exit;
      }

      // Validate password strength
      if (!validatePasswordStrength($password)) {
          echo "<script>
              window.onload = function() {
                  showMessage('error', 'Password must be at least 8 characters long, and include both letters and numbers.');
              };
          </script>";
          exit;
      }

      // Hash the password
      $hashed_password = password_hash($password, PASSWORD_BCRYPT);

      // Check if user with the same username or phone already exists
      $existingUser = $collection->findOne([
          '$or' => [
              ['username' => $username],
              ['phone' => $phone]
          ]
      ]);

      if ($existingUser) {
          echo "<script>
              window.onload = function() {
                  showMessage('error', 'Username or phone number already in use.');
              };
          </script>";
          exit;
      }

      // Insert the new user into the database
      $result = $collection->insertOne([
          'username' => $username,
          'firstname' => $firstname,
          'lastname' => $lastname,
          'phone' => $phone,
          'email' => $email,
          'gender' => $gender,
          'password' => $hashed_password,
          'created_at' => new MongoDB\BSON\UTCDateTime()
      ]);

      if ($result->getInsertedCount() === 1) {
          echo "<script>
              window.onload = function() {
                  showMessage('success', 'Registration successful!');
                  setTimeout(function() {
                      window.location.href = 'login.php';
                  }, 2000); // Redirect after 2 seconds
              };
          </script>";
          exit;
      } else {
          echo "<script>
              window.onload = function() {
                  showMessage('error', 'Registration failed. Please try again.');
              };
          </script>";
      }
  }
  ?>
</body>
</html>
