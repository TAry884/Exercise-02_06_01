<!doctype html>
<!--
Author: Ty Ary
Date: 10.24.18

Filename: PostGuest.php
-->

<html>
	<head>
		<title>Page Title</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
	</head>

	<body>
    <?php
        if (isset($_POST['submit'])) {
            $existing = array();
            if (file_exists("Orders.txt") && filesize("Orders.txt") > 0) {
                $orderArray = file("Orders.txt");
                $count = count($orderArray);
                for ($i = 0; $i < $count; $i++) {
                    $currOrd = explode("~", $orderArray[$i]);
                    $existing[] = $currOrd[0];
                }
                
            }
        }
//      if (isset($_POST['submit'])) {
//          $name = stripslashes($_POST['name']);
//          $email = stripslashes($_POST['email']);
//          $name = str_replace("~", "-", $name);
//          $email = str_replace("~", "-", $email);
//          $existing = array();
//          if (file_exists("Guests.txt") && filesize("Guests.txt") > 0) {
//              $messageArray = file("Guests.txt");
//              $count = count($messageArray);
//              for ($i = 0; $i < $count; $i++) {
//                  $currMsg = explode("~", $messageArray[$i]);
//                  $existing[] = $currMsg[0];
//              }
//          }
//          if (in_array($name, $existing)) {
//              echo "<p>The name <em>\"$name\"</em> you entered is already taken!<br>\n";
//              echo "Please try again<br>\n";
//              echo "Your name was not saved</p>";
//              $name = "";
//          } else {
//              $messageRecord = "$name~$email\n";
//              $fileHandle = fopen("Guests.txt", "ab");
//              if (!$fileHandle) {
//                  echo "There was a error saving your message\n";
//              } else {
//                  fwrite($fileHandle, $messageRecord);
//                  fclose($fileHandle);
//                  echo "Your message has been saved.\n";
//                  $name = "";
//                  $email = "";
//              }
//          }
//      } else {
//          $name = "";
//          $email = "";
//      }
    ?>
<!-- HTML form for submissions -->
    <h1>Guests</h1>
    <hr>
    <form action="PostGuest.php" method="post">
        <span style="font-weight: bold">1gb RAM<input type="checkbox" name="1ram" /></span>
        <span style="font-weight: bold">4gb RAM<input type="checkbox" name="2ram" /></span>
        <span style="font-weight: bold">8gb RAM<input type="checkbox" name="4ram" /></span>
        <span style="font-weight: bold">16gb RAM<input type="checkbox" name="16ram" /></span>
        <span style="font-weight: bold">32b RAM: <input type="checkbox" name="32ram" /></span>
        <input type="reset" name="reset" value="Reset Form" />
        <input type="submit" name="submit" value="Save Guest" />
    </form>
    <hr>
    <p>
        <a href="GuestBook.php">View Guests</a>
    </p>
	</body>
</html>