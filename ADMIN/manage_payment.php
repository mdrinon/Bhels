<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>
<?php require '../dbconnect.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_payment'])) {
        $id = new MongoDB\BSON\ObjectId($_POST['payment_id']);
        $company = $_POST['company'];
        $receiver = $_POST['receiver'];
        $mobile = $_POST['mobile'];
        $qr_code_url = $_POST['existing_qr_code'];

        // Handle QR code image upload
        if (isset($_FILES['qr_code']) && $_FILES['qr_code']['error'] == UPLOAD_ERR_OK) {
            $file = $_FILES['qr_code'];
            $upload_dir = 'uploads/payment-methods/'; // Define the upload directory

            // Check if the upload directory exists; if not, create it
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0775, true); // Create the directory with proper permissions
            }

            // Generate a unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file_name = uniqid() . '.' . $extension;
            $target_file = $upload_dir . $file_name;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                $qr_code_url = $target_file; // Save the file path for the database
            } else {
                echo '<p>Error uploading QR code image. Please try again.</p>';
                exit();
            }
        }

        // Prepare data for MongoDB
        $paymentData = [
            'company' => $company,
            'receiver' => $receiver,
            'mobile' => $mobile,
            'qr_code' => $qr_code_url,
            'updated_at' => new MongoDB\BSON\UTCDateTime()
        ];

        // Update the payment method in MongoDB
        try {
            $paymentsCollection = $db->payments; // Use the correct 'payments' collection
            $result = $paymentsCollection->updateOne(['_id' => $id], ['$set' => $paymentData]);

            // Display an alert box and refresh the page
            echo '<script type="text/javascript">';
            echo 'alert("Payment method updated successfully.");';
            echo 'window.location.href = window.location.href;';
            echo '</script>';
            exit();
        } catch (Exception $e) {
            echo '<p>Error updating payment method: ' . $e->getMessage() . '</p>';
        }
    } elseif (isset($_POST['delete_payment'])) {
        $id = new MongoDB\BSON\ObjectId($_POST['payment_id']);

        // Delete the payment method from MongoDB
        try {
            $paymentsCollection = $db->payments; // Use the correct 'payments' collection
            $result = $paymentsCollection->deleteOne(['_id' => $id]);

            // Display an alert box and refresh the page
            echo '<script type="text/javascript">';
            echo 'alert("Payment method deleted successfully.");';
            echo 'window.location.href = window.location.href;';
            echo '</script>';
            exit();
        } catch (Exception $e) {
            echo '<p>Error deleting payment method: ' . $e->getMessage() . '</p>';
        }
    } else {
        $company = $_POST['company'];
        $receiver = $_POST['receiver'];
        $mobile = $_POST['mobile'];
        $qr_code_url = null;

        // Handle QR code image upload
        if (isset($_FILES['qr_code']) && $_FILES['qr_code']['error'] == UPLOAD_ERR_OK) {
            $file = $_FILES['qr_code'];
            $upload_dir = 'uploads/payment-methods/'; // Define the upload directory

            // Check if the upload directory exists; if not, create it
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0775, true); // Create the directory with proper permissions
            }

            // Generate a unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file_name = uniqid() . '.' . $extension;
            $target_file = $upload_dir . $file_name;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                $qr_code_url = $target_file; // Save the file path for the database
            } else {
                echo '<p>Error uploading QR code image. Please try again.</p>';
                exit();
            }
        } else {
            echo '<p>No QR code image uploaded or an error occurred during file upload.</p>';
        }

        // Prepare data for MongoDB
        $paymentData = [
            'company' => $company,
            'receiver' => $receiver,
            'mobile' => $mobile,
            'qr_code' => $qr_code_url,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ];

        // Insert the payment method into MongoDB
        try {
            $paymentsCollection = $db->payments; // Use the correct 'payments' collection
            $result = $paymentsCollection->insertOne($paymentData);

            // Display an alert box and refresh the page
            echo '<script type="text/javascript">';
            echo 'alert("Payment method added successfully.");';
            echo 'window.location.href = window.location.href;';
            echo '</script>';
            exit();
        } catch (Exception $e) {
            echo '<p>Error adding payment method: ' . $e->getMessage() . '</p>';
        }
    }
}
?>

<style>
    
/* Modal styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    right: 0;
    top: 0;
    width: 400px; /* Full width */
    height: 100vh; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: #fefefe;
    box-shadow: -2px 0 5px rgba(0,0,0,0.5);
    font-family: Arial, sans-serif;
}

.modal-content {
    padding: 20px;
    border: 1px solid #888;
    width: 100%;
    height: calc(100% - calc(var(--topbar-height) + 10px));
    box-sizing: border-box;
    margin-top: calc(var(--topbar-height) + 10px);
}

.modal-close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.modal-close:hover,
.modal-close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.modal-content h2 {
    margin-top: 0;
}

.modal-content form {
    display: flex;
    flex-direction: column;
}

.modal-content form label {
    margin-top: 10px;
}

.modal-content form input {
    margin-bottom: 10px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.modal-content form button {
    align-self: flex-start;
    padding: 10px 20px;
    background-color: #cb5584;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.modal-content form button:hover {
    background-color: #c64581;
}
.card {
    background: #fff;
    border-radius: 20px;
    padding: 15px;
    box-shadow: 7px 7px 9px #d9d9d9, -7px -7px 9px #e7e7e7;
}
.payment__card {
    width: 285px;
    height: 300px;
    background: #c8c8c8;
    border-radius: 20px 20px 0 0;;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #000;
    transition: 0.2s ease-in-out;
    margin: 10px;
}
.payment__card > img {
    height: 300px;
    width: 285px;
    object-fit: cover;
    position: absolute;
    transition: 0.2s ease-in-out;
    border-radius: 20px 20px 0 0;;
    z-index: 1;
}

.textBox {
    opacity: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 15px;
    transition: 0.2s ease-in-out;
    z-index: 2;
    background: #ffffffa3;
    height: 300px;
    width: 285px;
    border-radius: 20px 20px 0 0;;
}
.textBox > p {
    margin: 0;
    text-align: center;
    padding: 0 10px;
}
.textBox > .text {
  font-weight: bold;
}

.textBox > .company {
  font-size: 20px;
}

.textBox > .number {
  font-size: 17px;
}

.textBox > span {
  font-size: 22px;
  font-weight: bold;
  color: #000;
}
.textBox > button {
  padding: 10px 20px;
  background: #cb5584;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.textBox > button:hover {
  background: #c64581;
}
form > button {
    padding: 10px 20px;
    background: #cb5584;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
form > button:hover {
    background: #c64581;
}
.payment__card:hover > .textBox {
  opacity: 1;
}

.payment__card:hover > img {
  height: 65%;
  filter: blur(7px);
  animation: anim 3s infinite;
}
.payment__card_info {
    margin: 0;
    padding: 10px;
}
.header {
    font-size: 20px;
    font-weight: bold;
    margin: 0;
}
.reference_no {
    font-size: 15px;
    margin: 0;
}

@keyframes anim {
  0% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-20px);
  }

  100% {
    transform: translateY(0);
  }
}

.card:hover {
  transform: scale(1.04) rotate(-1deg);
}


</style>
<section class="main-content">
    <div class="navigation">
        <div class="menu-tab"><h6><b>Manage Payments</b></h6></div>
        <div class="nav-label"><h2>Manage Payments</h2></div>
        <button id="addPaymentBtn" class="btn btn-primary">Add New Payment Method</button>
    </div>

    <div class="payment-container" style="display: block;">
        <div class="wrapper" style="justify-content: flex-start; gap:0;">
            
            <!-- payment methods in card gallery -->
            <?php
            try {
                // Fetch all payment methods
                $cursor = $db->payments->find([], ['sort' => ['created_at' => -1]]);

                foreach ($cursor as $payment): ?>
                <div class="card"
                    data-id="<?php echo $payment['_id']->__toString(); ?>" 
                    data-company="<?php echo htmlspecialchars($payment['company']); ?>" 
                    data-receiver="<?php echo htmlspecialchars($payment['receiver']); ?>"
                    data-mobile="<?php echo htmlspecialchars($payment['mobile']); ?>"
                    data-qr-code="<?php echo htmlspecialchars($payment['qr_code']); ?>">
                    
                    <div class="payment__card">
                        <img src="<?php echo htmlspecialchars($payment['qr_code']); ?>" alt="">
                        
                        <div class="textBox">
                            <span><?php echo htmlspecialchars($payment['receiver']); ?></span>
                            
                            <button class="btn btn-secondary updatePaymentBtn">Update</button>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="payment_id" value="<?php echo $payment['_id']->__toString(); ?>">
                            <button type="submit" name="delete_payment" class="btn btn-danger">Delete</button></form>
                        </div>
                    </div>

                    <div class="payment__card_info">
                        <p class="header"><?php echo htmlspecialchars($payment['company']); ?></p>
                        <p class="reference_no"><?php echo htmlspecialchars($payment['mobile']); ?></p>
                    </div>
                </div>
                <?php endforeach;
            } catch (Exception $e) {
                echo '<p>Error fetching payment methods: ' . $e->getMessage() . '</p>';
            }
            ?>
            
        </div>
    </div>
</section>

<!-- Modal for adding new payment method -->
<div id="addPaymentModal" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h2>Add New Payment Method</h2>
        <form id="addPaymentForm" method="post" enctype="multipart/form-data">
            <label for="company">Company Name:</label>
            <input type="text" id="company" name="company" required>
            
            <label for="receiver">Receiver Name:</label>
            <input type="text" id="receiver" name="receiver" required>
            
            <label for="mobile">Mobile Number:</label>
            <input type="text" id="mobile" name="mobile" required>
            
            <label for="qr_code">QR Code Image:</label>
            <input type="file" id="qr_code" name="qr_code" accept="image/*" required>
            
            <button type="submit" class="btn btn-primary">Add Payment Method</button>
        </form>
    </div>
</div>

<!-- Modal for updating payment method -->
<div id="updatePaymentModal" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h2>Update Payment Method</h2>
        <form id="updatePaymentForm" method="post" enctype="multipart/form-data">
            <input type="hidden" id="payment_id" name="payment_id">
            <label for="company">Company Name:</label>
            <input type="text" id="update_company" name="company" required>
            
            <label for="receiver">Receiver Name:</label>
            <input type="text" id="update_receiver" name="receiver" required>
            
            <label for="mobile">Mobile Number:</label>
            <input type="text" id="update_mobile" name="mobile" required>
            
            <label for="qr_code">QR Code Image:</label>
            <input type="file" id="update_qr_code" name="qr_code" accept="image/*">
            <input type="hidden" id="existing_qr_code" name="existing_qr_code">
            
            <button type="submit" name="update_payment" class="btn btn-primary">Update Payment Method</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set all payment containers to display block
    document.querySelectorAll('.payment').forEach(function(payment) {
        payment.style.display = 'block';
    });

    // Modal functionality
    var addModal = document.getElementById("addPaymentModal");
    var updateModal = document.getElementById("updatePaymentModal");
    var addBtn = document.getElementById("addPaymentBtn");
    var addClose = addModal.getElementsByClassName("modal-close")[0];
    var updateClose = updateModal.getElementsByClassName("modal-close")[0];

    addBtn.onclick = function() {
        addModal.style.display = "block";
    }

    addClose.onclick = function() {
        addModal.style.display = "none";
    }

    updateClose.onclick = function() {
        updateModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == addModal) {
            addModal.style.display = "none";
        } else if (event.target == updateModal) {
            updateModal.style.display = "none";
        }
    }

    // Update button functionality
    document.querySelectorAll('.updatePaymentBtn').forEach(function(btn) {
        btn.onclick = function() {
            var card = btn.closest('.payment__card');
            var id = card.getAttribute('data-id');
            var company = card.getAttribute('data-company');
            var receiver = card.getAttribute('data-receiver');
            var mobile = card.getAttribute('data-mobile');
            var qr_code = card.getAttribute('data-qr-code');

            document.getElementById('payment_id').value = id;
            document.getElementById('update_company').value = company;
            document.getElementById('update_receiver').value = receiver;
            document.getElementById('update_mobile').value = mobile;
            document.getElementById('existing_qr_code').value = qr_code;

            updateModal.style.display = "block";
        }
    });
});
</script>

<script defer src="javascript/notification.js"></script>
<script defer src="javascript/tooltips.js"></script>
<script defer src="javascript/sidebar.js"></script>
</body>
</html>
