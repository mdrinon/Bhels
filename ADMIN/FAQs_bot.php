<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>
<?php

// connecting to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->bheldb->faqs_bot;

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$sortField = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$sortOrder = isset($_GET['order']) && $_GET['order'] === 'asc' ? 1 : -1;

$filter = [];
if ($searchQuery) {
    $filter = [
        '$or' => [
            ['queries' => new MongoDB\BSON\Regex($searchQuery, 'i')],
            ['replies' => new MongoDB\BSON\Regex($searchQuery, 'i')]
        ]
    ];
}

$options = [
    'sort' => [$sortField => $sortOrder]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_message'])) {
        $id = new MongoDB\BSON\ObjectId($_POST['message_id']);
        $query = $_POST['query'];
        $reply = $_POST['reply'];

        // Prepare data for MongoDB
        $messageData = [
            'queries' => $query,
            'replies' => $reply,
            'updated_at' => new MongoDB\BSON\UTCDateTime()
        ];

        // Update the message in MongoDB
        try {
            $result = $collection->updateOne(['_id' => $id], ['$set' => $messageData]);

            // Display an alert box and refresh the page
            echo '<script type="text/javascript">';
            echo 'alert("Message updated successfully.");';
            echo 'window.location.href = window.location.href;';
            echo '</script>';
            exit();
        } catch (Exception $e) {
            echo '<p>Error updating message: ' . $e->getMessage() . '</p>';
        }
    } elseif (isset($_POST['delete_message'])) {
        $id = new MongoDB\BSON\ObjectId($_POST['message_id']);

        // Delete the message from MongoDB
        try {
            $result = $collection->deleteOne(['_id' => $id]);

            // Display an alert box and refresh the page
            echo '<script type="text/javascript">';
            echo 'alert("Message deleted successfully.");';
            echo 'window.location.href = window.location.href;';
            echo '</script>';
            exit();
        } catch (Exception $e) {
            echo '<p>Error deleting message: ' . $e->getMessage() . '</p>';
        }
    } else {
        $query = $_POST['query'];
        $reply = $_POST['reply'];

        // Prepare data for MongoDB
        $messageData = [
            'queries' => $query,
            'replies' => $reply,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ];

        // Insert the message into MongoDB
        try {
            $result = $collection->insertOne($messageData);

            // Display an alert box and refresh the page
            echo '<script type="text/javascript">';
            echo 'alert("Message added successfully.");';
            echo 'window.location.href = window.location.href;';
            echo '</script>';
            exit();
        } catch (Exception $e) {
            echo '<p>Error adding message: ' . $e->getMessage() . '</p>';
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

.modal-content form button , .updateMessageBtn:hover {
    background-color: #c64581;
}
form > button , .updateMessageBtn {
    padding: 10px 20px;
    background: #cb5584;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
form > button , .updateMessageBtn:hover {
    background: #c64581;
}
.table-container {
    margin-top: 0;
}
table {
    width: 100%;
    border-collapse: collapse;
    border-top: 2px solid #e5e5e5;
}
thead {
    background-color: #fff;
    height: 60px;
}
tbody {
    height: 40px;
    background-color: #fff;
    border-top: 2px solid #e5e5e5;
    border-bottom: 2px solid #e5e5e5;
}
/* table, th, td {
    border: 1px solid #ddd;
} */
th, td {
    padding: 8px;
    text-align: left;
}
th {
    cursor: pointer;
}
th.sort-asc::after {
    content: " ▲";
}
th.sort-desc::after {
    content: " ▼";
}
.search-container {
    margin-bottom: 20px;
}
.search-container input {
    padding: 8px;
    width: 300px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>

<section class="main-content" style="flex-direction: column;">
    <div class="navigation">
        <div class="menu-tab"><h6><b>Manage Messages</b></h6></div>
        <div class="nav-label"><h2>Frequently Asked Questions</h2></div>
        <button id="addMessageBtn" class="btn btn-primary">Add New Message</button>
    </div>

    <div class="search-container">
        <form method="get" action="FAQs_bot.php">
            <input type="text" name="search" placeholder="Search messages or replies..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th onclick="sortTable('queries')">QUERIES</th>
                    <th onclick="sortTable('replies')">REPLIES</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Fetch all messages
                    $cursor = $collection->find($filter, $options);

                    foreach ($cursor as $message): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($message['queries']); ?></td>
                        <td><?php echo htmlspecialchars($message['replies']); ?></td>
                        <td>
                            <button class="updateMessageBtn" data-id="<?php echo $message['_id']->__toString(); ?>" data-query="<?php echo htmlspecialchars($message['queries']); ?>" data-reply="<?php echo htmlspecialchars($message['replies']); ?>">Edit</button>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="message_id" value="<?php echo $message['_id']->__toString(); ?>">
                                <button type="submit" name="delete_message" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach;
                } catch (Exception $e) {
                    echo '<tr><td colspan="3">Error fetching messages: ' . $e->getMessage() . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal for adding new message -->
<div id="addMessageModal" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h2>Add New Message</h2>
        <form id="addMessageForm" method="post">
            <label for="query">Message:</label>
            <input type="text" id="query" name="query" required>
            
            <label for="reply">Reply:</label>
            <input type="text" id="reply" name="reply" required>
            
            <button type="submit" class="btn btn-primary">Add Message</button>
        </form>
    </div>
</div>

<!-- Modal for updating message -->
<div id="updateMessageModal" class="modal">
    <div class="modal-content">
        <span class="modal-close">&times;</span>
        <h2>Update Message</h2>
        <form id="updateMessageForm" method="post">
            <input type="hidden" id="message_id" name="message_id">
            <label for="query">Message:</label>
            <input type="text" id="update_query" name="query" required>
            
            <label for="reply">Reply:</label>
            <input type="text" id="update_reply" name="reply" required>
            
            <button type="submit" name="update_message" class="btn btn-primary">Update Message</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal functionality
    var addModal = document.getElementById("addMessageModal");
    var updateModal = document.getElementById("updateMessageModal");
    var addBtn = document.getElementById("addMessageBtn");
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
    document.querySelectorAll('.updateMessageBtn').forEach(function(btn) {
        btn.onclick = function() {
            var id = btn.getAttribute('data-id');
            var query = btn.getAttribute('data-query');
            var reply = btn.getAttribute('data-reply');

            document.getElementById('message_id').value = id;
            document.getElementById('update_query').value = query;
            document.getElementById('update_reply').value = reply;

            updateModal.style.display = "block";
        }
    });
});

function sortTable(field) {
    var currentUrl = new URL(window.location.href);
    var currentSortField = currentUrl.searchParams.get('sort');
    var currentSortOrder = currentUrl.searchParams.get('order');

    if (currentSortField === field) {
        currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
    } else {
        currentSortOrder = 'asc';
    }

    currentUrl.searchParams.set('sort', field);
    currentUrl.searchParams.set('order', currentSortOrder);

    window.location.href = currentUrl.toString();
}
</script>

<script defer src="javascript/notification.js"></script>
<script defer src="javascript/tooltips.js"></script>
<script defer src="javascript/sidebar.js"></script>
<script defer src="../javascript/chatbot.js"></script>
<?php include('../partials/chatbot.php'); ?>
<?php include('partials/footer.php'); ?>