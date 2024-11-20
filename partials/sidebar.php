<!-- BURGERR -->
  <div class="burger-menu">
    <h4 id="menu">Menu</h4>
    <label class="burger" for="burger" onclick="toggleBurger()">
      <input type="checkbox" id="burger">
      <span></span>
      <span></span>
      <span></span>
    </label>
  </div>

  <div class="sidebar">
    <div class="sidebar-menu">
      <ul>
        <li>
          <a class="Sb-Btn" href="Home.php">
            <img src="images/svg/home.png" class="sb-svg" alt="">
            <span class="sb-menu" id="home">Home</span>
            <span class="tooltip move-left" id="home">Home</span>
          </a>
        </li>
        <!-- <li>
          <a class="Sb-Btn" href="Dashboard.php">
            <img src="images/svg/dashboard.png" class="sb-svg" alt="">
            <span class="sb-menu" id="shop">Dashboard</span>
            <span class="tooltip move-left" id="shop">Dashboard</span>
          </a>
        </li> -->
        <li>
          <a class="Sb-Btn" href="Designs.php">
            <img src="images/svg/designs.png" class="sb-svg" alt="">
            <span class="sb-menu" id="blog">Designs</span>
            <span class="tooltip move-left" id="blog">Designs</span>
          </a>
        </li>
        <li>
          <a class="Sb-Btn" href="customize.php">
            <img src="images/svg/icons8-buy-100.png" class="sb-svg" alt="">
            <span class="sb-menu" id="cart">Order Now</span>
            <span class="tooltip move-left" id="cart">Order Now</span>
          </a>
        </li>
        <li>
          <a class="Sb-Btn" href="Orders.php">
            <img src="images/svg/orders.png" class="sb-svg" alt="">
            <span class="sb-menu" id="cart">Orders</span>
            <span class="tooltip move-left" id="cart">Orders</span>
          </a>
        </li>
        <li>
          <a class="Sb-Btn" href="Blog.php">
            <img src="images/svg/blog.png" class="sb-svg" alt="">
            <span class="sb-menu" id="cart">Blog</span>
            <span class="tooltip move-left" id="cart">Blog</span>
          </a>
        </li>
      </ul>
   </div>
  </div>
  <div class="sidebar-bottom Sb-Btn" id="sidebar-bottom">
    <a class="Sb-Btn" href="#">
      <img src="images/svg/setting.png" class="sb-svg" alt="">
      <span class="sb-bottom-menu" id="settings">Settings</span>
      <span class="tooltip move-left" id="settings-tooltip">Settings</span>
    </a>
</div>