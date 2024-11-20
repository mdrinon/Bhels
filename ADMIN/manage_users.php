<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>
<?php require '../dbconnect.php'; ?>

<section class="main-content">
    <div class="navigation">
        <div class="menu-tab"><h6><b>Manage Users</b></h6></div>
        <div class="nav-label"><h2>Manage Users</h2></div>
    </div>

    <div class="user-container" style="display: block;">
        <div class="wrapper" style="justify-content: flex-start; gap:0;">
            
            <!-- users in card gallery -->
            <?php
            try {
                // Fetch all user accounts
                $cursor = $db->accounts->find([], ['sort' => ['created_at' => -1]]);

                foreach ($cursor as $user): ?>
                    <div class="user_profile_card"
                        data-id="<?php echo $user['_id']->__toString(); ?>" 
                        data-name="<?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>" 
                        data-gender="<?php echo htmlspecialchars($user['gender']); ?>"
                        data-username="<?php echo htmlspecialchars($user['username']); ?>" 
                        data-email="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" 
                        data-phone="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">

                        <div class="user_profileImage">
                            <img src="uploads/user-profile/<?php echo htmlspecialchars($user['gender']); ?>.jpg" alt="">
                        </div>
                        <div class="user_info_textContainer">
                            <p class="user_account_name"><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></p>
                            <p class="users_username">@<?php echo htmlspecialchars($user['username']); ?></p>
                        </div>
                    </div>
                <?php endforeach;
            } catch (Exception $e) {
                echo '<p>Error fetching user accounts: ' . $e->getMessage() . '</p>';
            }
            ?>

        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set all user containers to display block
    document.querySelectorAll('.user').forEach(function(user) {
        user.style.display = 'block';
    });
});
</script>


<script defer src="javascript/notification.js"></script>
<script defer src="javascript/tooltips.js"></script>
<script defer src="javascript/sidebar.js"></script>
</body>
</html>
