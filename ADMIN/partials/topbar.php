  <div class="topbar">
    <div class="top-left">
      <div class="logo">
        <img src="images/logo.png" alt="logo">
      </div>
    </div>
    <div class="top-right">
      <div class="profile-card">
        <div class="profile-picture">
          <div class="notification">1</div>
        </div>
        <div class="profile-info">
        <div class="username">
          <?php 

            // Check if the session variables 'firstname' and 'lastname' are set
            if (isset($_SESSION['firstname']) && isset($_SESSION['lastname'])) {
                // Display the full name if the user is logged in
                echo htmlspecialchars($_SESSION['firstname']) . ' ' . htmlspecialchars($_SESSION['lastname']);
            } else {
                // Display "Guest" if the user is not logged in
                echo "Guest";
            }
          ?>
        </div>


          <div class="handle">
              <?php 
              // Check if the session variable 'username' is set
              if (isset($_SESSION['username'])) {
                  // Display the username handle if the user is logged in
                  echo '@' . htmlspecialchars($_SESSION['username']);
              } else {
                  // Display the "Login Now" link if the user is not logged in
                  echo '<a href="login.php">Login Now</a>';
              }
              ?>
          </div>
        </div>
        <button class="profile__sub__menu__btn">
          <svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg">
          <path d="M140,128a12,12,0,1,1-12-12A12,12,0,0,1,140,128ZM128,72a12,12,0,1,0-12-12A12,12,0,0,0,128,72Zm0,112a12,12,0,1,0,12,12A12,12,0,0,0,128,184Z"></path></svg>
        </button>
        <div class="profile__menu" id="profileMenu">
          <button class="profile__menu__value">
            <svg
              viewBox="0 0 16 16"
              xmlns="http://www.w3.org/2000/svg"
              data-name="Layer 2"
            >
              <path
                d="m1.5 13v1a.5.5 0 0 0 .3379.4731 18.9718 18.9718 0 0 0 6.1621 1.0269 18.9629 18.9629 0 0 0 6.1621-1.0269.5.5 0 0 0 .3379-.4731v-1a6.5083 6.5083 0 0 0 -4.461-6.1676 3.5 3.5 0 1 0 -4.078 0 6.5083 6.5083 0 0 0 -4.461 6.1676zm4-9a2.5 2.5 0 1 1 2.5 2.5 2.5026 2.5026 0 0 1 -2.5-2.5zm2.5 3.5a5.5066 5.5066 0 0 1 5.5 5.5v.6392a18.08 18.08 0 0 1 -11 0v-.6392a5.5066 5.5066 0 0 1 5.5-5.5z"
              ></path>
            </svg>
            Profile
          </button>
          <button class="profile__menu__value">
            <svg id="svg__nofill" width="16px" height="16px" viewBox="2 1 20 20" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier" stroke-width="1.5"> <path d="M11.8456 6.42726L12 6.59097L12.1544 6.42726C14.132 4.33053 17.4026 4.57697 19.0807 6.94915C20.57 9.05459 20.2133 12.0335 18.275 13.6776L12 19L5.725 13.6776C3.78668 12.0335 3.42999 9.05459 4.91934 6.94915C6.59738 4.57698 9.86801 4.33053 11.8456 6.42726Z" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            Likes
          </button>

          <button class="profile__menu__value" id="notificationTrigger">
            <svg viewBox="0 0 24 25" xmlns="http://www.w3.org/2000/svg">
              <path
                clip-rule="evenodd"
                d="m11.9572 4.31201c-3.35401 0-6.00906 2.59741-6.00906 5.67742v3.29037c0 .1986-.05916.3927-.16992.5576l-1.62529 2.4193-.01077.0157c-.18701.2673-.16653.5113-.07001.6868.10031.1825.31959.3528.67282.3528h14.52603c.2546 0 .5013-.1515.6391-.3968.1315-.2343.1117-.4475-.0118-.6093-.0065-.0085-.0129-.0171-.0191-.0258l-1.7269-2.4194c-.121-.1695-.186-.3726-.186-.5809v-3.29037c0-1.54561-.6851-3.023-1.7072-4.00431-1.1617-1.01594-2.6545-1.67311-4.3019-1.67311zm-8.00906 5.67742c0-4.27483 3.64294-7.67742 8.00906-7.67742 2.2055 0 4.1606.88547 5.6378 2.18455.01.00877.0198.01774.0294.02691 1.408 1.34136 2.3419 3.34131 2.3419 5.46596v2.97007l1.5325 2.1471c.6775.8999.6054 1.9859.1552 2.7877-.4464.795-1.3171 1.4177-2.383 1.4177h-14.52603c-2.16218 0-3.55087-2.302-2.24739-4.1777l1.45056-2.1593zm4.05187 11.32257c0-.5523.44772-1 1-1h5.99999c.5523 0 1 .4477 1 1s-.4477 1-1 1h-5.99999c-.55228 0-1-.4477-1-1z"
                fill-rule="evenodd"
              ></path>
            </svg>
            Notifications
          </button>
          
          <button class="profile__menu__value">
            <svg id="Line" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
              <path
                id="XMLID_1646_"
                d="m17.074 30h-2.148c-1.038 0-1.914-.811-1.994-1.846l-.125-1.635c-.687-.208-1.351-.484-1.985-.824l-1.246 1.067c-.788.677-1.98.631-2.715-.104l-1.52-1.52c-.734-.734-.78-1.927-.104-2.715l1.067-1.246c-.34-.635-.616-1.299-.824-1.985l-1.634-.125c-1.035-.079-1.846-.955-1.846-1.993v-2.148c0-1.038.811-1.914 1.846-1.994l1.635-.125c.208-.687.484-1.351.824-1.985l-1.068-1.247c-.676-.788-.631-1.98.104-2.715l1.52-1.52c.734-.734 1.927-.779 2.715-.104l1.246 1.067c.635-.34 1.299-.616 1.985-.824l.125-1.634c.08-1.034.956-1.845 1.994-1.845h2.148c1.038 0 1.914.811 1.994 1.846l.125 1.635c.687.208 1.351.484 1.985.824l1.246-1.067c.787-.676 1.98-.631 2.715.104l1.52 1.52c.734.734.78 1.927.104 2.715l-1.067 1.246c.34.635.616 1.299.824 1.985l1.634.125c1.035.079 1.846.955 1.846 1.993v2.148c0 1.038-.811 1.914-1.846 1.994l-1.635.125c-.208.687-.484 1.351-.824 1.985l1.067 1.246c.677.788.631 1.98-.104 2.715l-1.52 1.52c-.734.734-1.928.78-2.715.104l-1.246-1.067c-.635.34-1.299.616-1.985.824l-.125 1.634c-.079 1.035-.955 1.846-1.993 1.846zm-5.835-6.373c.848.53 1.768.912 2.734 1.135.426.099.739.462.772.898l.18 2.341 2.149-.001.18-2.34c.033-.437.347-.8.772-.898.967-.223 1.887-.604 2.734-1.135.371-.232.849-.197 1.181.089l1.784 1.529 1.52-1.52-1.529-1.784c-.285-.332-.321-.811-.089-1.181.53-.848.912-1.768 1.135-2.734.099-.426.462-.739.898-.772l2.341-.18h-.001v-2.148l-2.34-.18c-.437-.033-.8-.347-.898-.772-.223-.967-.604-1.887-1.135-2.734-.232-.37-.196-.849.089-1.181l1.529-1.784-1.52-1.52-1.784 1.529c-.332.286-.81.321-1.181.089-.848-.53-1.768-.912-2.734-1.135-.426-.099-.739-.462-.772-.898l-.18-2.341-2.148.001-.18 2.34c-.033.437-.347.8-.772.898-.967.223-1.887.604-2.734 1.135-.37.232-.849.197-1.181-.089l-1.785-1.529-1.52 1.52 1.529 1.784c.285.332.321.811.089 1.181-.53.848-.912 1.768-1.135 2.734-.099.426-.462.739-.898.772l-2.341.18.002 2.148 2.34.18c.437.033.8.347.898.772.223.967.604 1.887 1.135 2.734.232.37.196.849-.089 1.181l-1.529 1.784 1.52 1.52 1.784-1.529c.332-.287.813-.32 1.18-.089z"
              ></path>
              <path
                id="XMLID_1645_"
                d="m16 23c-3.859 0-7-3.141-7-7s3.141-7 7-7 7 3.141 7 7-3.141 7-7 7zm0-12c-2.757 0-5 2.243-5 5s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z"
              ></path>
            </svg>
            Account
          </button>
          <button class="profile__menu__value" id="logoutButton">
            <svg height="15px" width="64px" version="1.1" id="图层_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="10 10 20 20" enable-background="new 0 0 30 30" xml:space="preserve" stroke="#7D8590" stroke-width="0.7"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke-width="0.14"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <g> <g> <path d="M24,23.5c-0.1,0-0.3,0-0.4-0.1c-0.2-0.2-0.2-0.5,0-0.7l2.6-2.6l-2.6-2.6c-0.2-0.2-0.2-0.5,0-0.7 s0.5-0.2,0.7,0l3,3c0.2,0.2,0.2,0.5,0,0.7l-3,3C24.3,23.5,24.1,23.5,24,23.5z"></path> </g> <g> <path d="M26.5,20.5h-8c-0.3,0-0.5-0.2-0.5-0.5s0.2-0.5,0.5-0.5h8c0.3,0,0.5,0.2,0.5,0.5S26.8,20.5,26.5,20.5z"></path> </g> </g> <g> <path d="M21,27.5h-6c-1.4,0-2.5-1.1-2.5-2.5V15c0-1.4,1.1-2.5,2.5-2.5h6c0.3,0,0.5,0.2,0.5,0.5s-0.2,0.5-0.5,0.5 h-6c-0.8,0-1.5,0.7-1.5,1.5v10c0,0.8,0.7,1.5,1.5,1.5h6c0.3,0,0.5,0.2,0.5,0.5S21.3,27.5,21,27.5z"></path> </g> </g> </g> </g> </g></svg>
            Logout
          </button>
        </div>
        <div id="notification-container" class="notification-container">
          <div id="notificationTrigger" class="notification_header">
            <h3>Notifications</h3>
            <div class="notification_header_btns">
              <button class="clear_all_btn">
                <img src="../images/svg/broom.png" alt="">
              </button>
              <button class="Mark-all-as-read">
                <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" width="64px" height="64px" viewBox="-6.76 -6.76 65.52 65.52" enable-background="new 0 0 52 52" xml:space="preserve" transform="rotate(0)matrix(1, 0, 0, 1, 0, 0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M24,7l-1.7-1.7c-0.5-0.5-1.2-0.5-1.7,0L10,15.8l-4.3-4.2c-0.5-0.5-1.2-0.5-1.7,0l-1.7,1.7 c-0.5,0.5-0.5,1.2,0,1.7l5.9,5.9c0.5,0.5,1.1,0.7,1.7,0.7c0.6,0,1.2-0.2,1.7-0.7L24,8.7C24.4,8.3,24.4,7.5,24,7z"></path> <path d="M48.4,18.4H27.5c-0.9,0-1.6-0.7-1.6-1.6v-3.2c0-0.9,0.7-1.6,1.6-1.6h20.9c0.9,0,1.6,0.7,1.6,1.6v3.2 C50,17.7,49.3,18.4,48.4,18.4z"></path> <path d="M48.4,32.7H9.8c-0.9,0-1.6-0.7-1.6-1.6v-3.2c0-0.9,0.7-1.6,1.6-1.6h38.6c0.9,0,1.6,0.7,1.6,1.6v3.2 C50,32,49.3,32.7,48.4,32.7z"></path> <path d="M48.4,47H9.8c-0.9,0-1.6-0.7-1.6-1.6v-3.2c0-0.9,0.7-1.6,1.6-1.6h38.6c0.9,0,1.6,0.7,1.6,1.6v3.2 C50,46.3,49.3,47,48.4,47z"></path> </g></svg>
              </button>
            </div>
          </div>
          <div class="notification-item"><span class="text__notif">Welcome @<?php echo htmlspecialchars($_SESSION['username']); ?>!</span><span class="close_notif_btn">×</span></div>
          <!-- other notifications here -->
        </div>
      </div>
    </div>
  </div>