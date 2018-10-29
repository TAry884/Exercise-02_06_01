<!doctype html>
<!--
Author:Ty Ary
Date: 10.19.18

Filename: MessageBoard.php
-->

<html>
	<head>
		<title>Message Board</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<script src="modernizr.custom.65897.js"></script>
	</head>
    
	<body>
<!-- HTML form for submission -->
    <h1>Message Board</h1>
    <?php
        //If the action is used and if messages.txt exists as well as a file size is not equal to 0
    if (isset($_GET['action'])) {
        if (file_exists("messages.txt") && filesize("messages.txt") != 0) {
            //switches
            $messageArray = file("messages.txt");
            switch ($_GET['action']) {
                case 'Delete First':
                    array_shift($messageArray);
                    break;
                case 'Delete Last':
                    array_pop($messageArray);
                    break;
                case 'Sort Ascending':
                    sort($messageArray);
                    break; 
                case 'Sort Descending':
                    rsort($messageArray);
                    break;
                case 'Delete Message':
                    array_splice($messageArray, $_GET['message'],1);
//                    $index = $_GET['message'];
//                    unset($messageArray[$index]);
//                    $messageArray = array_values($messageArray);
                    break;
                case 'Remove Duplicates':
                    $messageArray = array_unique($messageArray);
                    $messageArray = array_values($messageArray);
                    break;
            }
            if (count($messageArray) > 0) {
                $newMessages = implode($messageArray);
                $fileHandle = fopen("messages.txt", "wb");
                if (!$fileHandle) {
                    echo "There was an error updating the message file";
                } else {
                    fwrite($fileHandle, $newMessages);
                    fclose($fileHandle);    
                }
            } else {
                unlink("messages.txt");
            }
        }
    }
    //If the file doesnt exist or there is no file size then tell the user that no messages were posted
    if (!file_exists("messages.txt") || filesize("messages.txt") == 0) {
        echo "<p>There are no messages posted.</p>";
    } else {
        //Sets the file that will be used as messages.txt
        $messageArray = file("messages.txt");
        echo "<table style=\"background-color: lightgray\" border=\"1\" width=\"100%\">\n";
        //This creates a number for how many things are inside the array
        $count = count($messageArray);
        for ($i = 0; $i < $count; $i++) {
            $currMsg = explode("~", $messageArray[$i]);
            $keyMessageArray[$currMsg[0]] = $currMsg[1] . "~" . $currMsg[2];
        }
        //Takes the place of the $i in for loop
        $index = 1;
        $key = key($keyMessageArray);
        //loops through the array and displays the values that are inside of them
        foreach ($keyMessageArray as $message) {
            //Explodes the value in $message so that it is capable of being used and picked out as if it was in a indexed array
            $currMsg = explode("~", $message);
            echo "<tr>\n";
            echo "<td width=\"5%\" style=\"text-align: center;\" font-weight=bold\">" . $index . "</td>\n";
            echo "<td width=\"85%\"><span style=\"font-weight: bold\">Subject: </span>" . htmlentities($key) . "<br>\n";
            echo "<span style=\"font-weight: bold\">Name: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "<span style=\"text-decoration: underline; font-weight: bold\">Message: </span><br>\n" . htmlentities($currMsg[1]) . "</td>\n";
            echo "<td width=\"10%\" style=\"text-align: center\">" . "<a href='MessageBoard.php?" . "action=Delete%20Message&" . "message=" . ($index - 1) . "'>" . "Delete This Message</a></td>\n";
            echo "</tr>\n";
            ++$index;
            next($keyMessageArray);
            $key = key($keyMessageArray);
        }
        echo "</table>";
    }
    ?>
    <p>
        <a href="PostMessage.php">Post New Message</a><br>
        <a href="MessageBoard.php?action=Sort%20Ascending">Sort Subject A-Z</a><br>
        <a href="MessageBoard.php?action=Sort%20Descending">Sort Subject Z-A</a><br>
        <a href="MessageBoard.php?action=Delete%20First">Delete First Message</a><br>
        <a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a><br>
   <!-- <a href="MessageBoard.php?action=Remove%20Duplicates">Remove Duplicate Message</a><br> -->
    </p>
	</body>
</html>