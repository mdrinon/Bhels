  <section id="fb-root" class="chatbot" style="display:none;">

    <div class="chat-button">
      <a href="Create_new_post.php"><img style="height: 40px" src="images/svg/icons8-edit-64.png"></a>
    </div>

    <div class="bot">
      <div class="wrapper">
        <button class="close-btn">X</button>
          <div class="title">chatbot</div>
          <div class="form">
            <div class="bot-inbox inbox">
                <div class="icon">🤖</div>
                <div class="msg-header">
                    <p>Hello there, how can I help you?</p>
                </div>
              </div>
            </div>
            <div class="typing-field">
              <div class="input-data">
                  <input id="data" type="text" placeholder="Type something here.." required>
                  <button id="send-btn">Send</button>
              </div>
            </div>
        </div>
    </div>
<!-- Your Chat Plugin code -->
<!-- <div class="fb-customerchat"
  attribution="setup_tool"
  page_id="1534704357106026"
  theme_color="#cb5584"
  logged_in_greeting="Hi! How can we help you?"
  logged_out_greeting="Hi! How can we help you?">
</div> -->
  </section>




<!-- <script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v13.0'
    });
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script> -->