<!doctype html>
<!--
Author: Ty Ary
Date: 10.25.18

Filename: PostOrders.php
-->

<html>
	<head>
		<title>Page Title</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
	</head>

	<body>
    <?php
      $order = array()
      if (isset($_POST['submit'])) {
          $name = stripslashes($_POST['name']);
          $email = stripslashes($_POST['email']);
          $name = str_replace("~", "-", $name);
          $email = str_replace("~", "-", $email);
          $existing = array();
          if (file_exists("Orders.txt") && filesize("Orders.txt") > 0) {
              $messageArray = file("Orders.txt");
              $count = count($messageArray);
              for ($i = 0; $i < $count; $i++) {
                  $currMsg = explode("~", $messageArray[$i]);
                  $existing[] = $currMsg[0];
              }
          }
          if (in_array($name, $existing)) {
              echo "<p>The name <em>\"$name\"</em> you entered is already taken!<br>\n";
              echo "Please try again<br>\n";
              echo "Your name was not saved</p>";
              $name = "";
          } else {
              $messageRecord = "$name~$email\n";
              $fileHandle = fopen("Orders.txt", "ab");
              if (!$fileHandle) {
                  echo "There was a error saving your order\n";
              } else {
                  fwrite($fileHandle, $orderRecord);
                  fclose($fileHandle);
                  echo "Your order has been saved.\n";
              }
          }
      }
    ?>
<!-- HTML form for submissions -->
    <h1>Guests</h1>
    <hr>
    <form action="PostGuest.php" method="post">
        <span style="font-weight: bold">Name: <input type="text" name="name" value="<?php echo $name;?>"/></span>
        <span style="font-weight: bold">E-Mail: <input type="text" name="email" value="<?php echo $email;?>"/></span>
        <input type="reset" name="reset" value="Reset Form" />
        <input type="submit" name="submit" value="Save Guest" />
    </form>
    <hr>
    <p>
        <a href="OnlineOrders.php">View Guests</a>
    </p>
	</body>
</html>