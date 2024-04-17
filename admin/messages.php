<?php
include '../components/connect.php';

if(isset($_COOKIE['admin_id'])){
   $admin_id = $_COOKIE['admin_id'];
}else{
   $admin_id = '';
   header('location:login.php');
}

// Handle message deletion
if(isset($_POST['delete'])){
   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `messages` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if($verify_delete->rowCount() > 0){
      $delete_bookings = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
      $delete_bookings->execute([$delete_id]);
      $success_msg[] = 'Message deleted!';
   }else{
      $warning_msg[] = 'Message deleted already!';
   }
}

// Handle message reply
if(isset($_POST['reply'])) {
   $reply_id = $_POST['reply_id'];
   $reply_id = filter_var($reply_id, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE id = ?");
   $select_message->execute([$reply_id]);
   $message = $select_message->fetch(PDO::FETCH_ASSOC);

   $recipient_email = $message['email'];
   $recipient_name = $message['name'];
   $reply_message = $_POST['reply_message'];
   $reply_message = filter_var($reply_message, FILTER_SANITIZE_STRING);

   // Send the reply message to the recipient
   // You can use your preferred method to send the email here
   // For example, using PHP's built-in mail() function:
   $subject = "Reply to your message";
   $body = "Dear $recipient_name,\n\nThank you for your message. Here is our reply:\n\n$reply_message";
   $headers = "From: your-email@example.com";
   mail($recipient_email, $subject, $body, $headers);

   $success_msg[] = 'Reply sent!';
}

// Fetch all messages received by the admin
$select_messages = $conn->prepare("SELECT * FROM `messages`");
$select_messages->execute();
$messages = $select_messages->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Inbox</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include '../components/admin_header.php'; ?>
<!-- header section ends -->

<!-- inbox section starts  -->
<section class="grid">
   <h1 class="heading">Inbox</h1>

   <div class="box-container">
   <?php
   if(!empty($messages)){
      foreach($messages as $message){
   ?>
      <div class="box">
         <p>From: <span><?= $message['name']; ?></span></p>
         <p>Email: <a href="mailto:<?= $message['email']; ?>"><?= $message['email']; ?></a></p>
         <p>Message: <span><?= $message['message']; ?></span></p>
         <form action="" method="POST">
            <input type="hidden" name="delete_id" value="<?= $message['id']; ?>">
            <input type="submit" value="Delete" onclick="return confirm('Delete this message?');" name="delete" class="delete-btn">
         </form>
         <form action="" method="POST">
            <input type="hidden" name="reply_id" value="<?= $message['id']; ?>">
            <textarea name="reply_message" placeholder="Enter your reply message" required></textarea>
            <input type="submit" value="Reply" name="reply" class="reply-btn">
         </form>
      </div>
   <?php
      }
   } else {
      echo '<p class="empty">You have no messages!</p>';
   }
   ?>
   </div>
</section>
<!-- inbox section ends  -->

</body>
</html>

<!-- messages section ends -->
















<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

<?php include '../components/message.php'; ?>

</body>
</html>