<?php
include 'components/connect.php'; // Include the connect.php file
?>

<header class="header">
   <nav class="navbar nav-1">
      <section class="flex">
         <a href="home.php" class="logo"><i class="fas fa-house"></i>LingsaFA</a>

         <ul>
            <li><a href="post_property.php">post property<i class="fas fa-paper-plane"></i></a></li>
         </ul>
      </section>
   </nav>

   <nav class="navbar nav-2">
      <section class="flex">
         <div id="menu-btn" class="fas fa-bars"></div>

         <div class="menu">
            <ul>
               <li><a href="#">my listings<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="dashboard.php">dashboard</a></li>
                     <li><a href="my_listings.php">my listings</a></li>
                  </ul>
               </li>
               <li><a href="#">options<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="search.php">filter search</a></li>
                  </ul>
               </li>
               <li><a href="#">help<i class="fas fa-angle-down"></i></a>
                  <ul>
                     <li><a href="contact.php">contact us</a></li>
                  </ul>
               </li>
            </ul>
         </div>

         <ul>
            <li><a href="saved.php">saved <i class="far fa-heart"></i></a></li>
            <li><a href="#">account <i class="fas fa-angle-down"></i></a>
               <ul>
                  <li><a href="login.php">login now</a></li>
                  <li><a href="register.php">register new</a></li>
                  <?php if($user_id != ''){ ?>
                  <li><a href="update.php">update profile</a></li>
                  <li><a href="components/user_logout.php" onclick="return confirm('logout from this website?');">logout</a>
                  <?php } ?></li>
               </ul>
            </li>
         </ul>
      </section>
   </nav>



</header>

<!-- JavaScript code -->
<script>
document.getElementById('open-chat').addEventListener('click', function() {
   document.getElementById('chat-popup').style.display = 'block';
});

document.getElementById('send-button').addEventListener('click', function() {
   const recipient = document.getElementById('recipient-select').value;
   const messageInput = document.getElementById('message-input');
   const messageContent = messageInput.value.trim();
   if (recipient && messageContent !== '') {
      const chatMessages = document.getElementById('chat-messages');
      const message = {
         sender: 'You', // Assuming the sender is the current user
         recipient: recipient,
         content: messageContent
      };
      chatMessages.innerHTML += '<div>' + message.sender + ' to ' + message.recipient + ': ' + message.content + '</div>';
      chatMessages.scrollTop = chatMessages.scrollHeight;
      messageInput.value = '';
   } else {
      alert('Please select a recipient and type a message.');
   }
});
</script>

<!-- CSS styles -->
<style>
.chat-popup {
   display: none;
   position: fixed;
   bottom: 20px;
   right: 20px;
   z-index: 9999;
}

.chat-box {
   width: 300px;
   background-color: #f9f9f9;
   border: 1px solid #ccc;
   border-radius: 5px;
   padding: 10px;
}

.chat-messages {
   height: 200px;
   overflow-y: scroll;
   margin-bottom: 10px;
}

#message-input {
   width: calc(100% - 80px); /* Adjusted to fit send button */
   padding: 5px;
   margin-right: 5px;
}

#send-button {
   padding: 5px 10px;
   background-color: #007bff;
   color: #fff;
   border: none;
   border-radius: 3px;
   cursor: pointer;
}
</style>
