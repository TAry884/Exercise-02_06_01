<!doctype html>

<!--
Author: Ty Ary
Date: 10.24.18

Filename: 10.24.18
-->
<html>
	<head>
		<title>Page Title</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
	</head>

	<body>
<!-- HTML for for submission -->
    <h1>Registered Guests</h1>
    <?php
    if (isset($_GET['action'])) {
        $guestArray = file("Guests.txt");
        switch ($_GET['action']) {
            case 'Delete First':
                array_shift($guestArray);
                break;
            case 'Delete Last':
                array_pop($guestArray);
                break;
            case 'Sort Ascending':
                sort($guestArray);
                break;
            case 'Sort Descending':
                rsort($guestArray);
                break;
            case 'Delete Message':
                array_splice($guestArray, $_GET['message'],1);
                break;
            case 'Remove Duplicates':
                $guestArray = array_unique($guestArray);
                $guestArray = array_values($guestArray);
                break;
        }
        if (count($guestArray) > 0) {
            $newGuest = implode($guestArray);
            $fileHandle = fopen("Guest.txt", "wb");
            if (!$fileHandle) {
                echo "There was a error saving your information";
            } else {
                fwrite($fileHandle, $newGuest);
                fclose($fileHandle);
            }
        } else {
            unlink("Guests.txt");
        }
    }
    if (!file_exists("Guests.txt") || filesize("Guests.txt") == 0) {
        echo "<p>There are no guests";
    } else {
        $guestArray = file("Guests.txt");
        echo "<table style=\"background-color: lightgray\" border=\"1\" width=\"100%\">\n";
        $count = count($guestArray);
        for ($i = 0; $i < $count; $i++) {
            $currMsg = explode("~", $guestArray[$i]);
            $keyGuestArray[$currMsg[0]] = $currMsg[1] . "~";
        }
        $index = 1;
        $key = key($keyGuestArray);
        foreach ($keyGuestArray as $guest) {
            echo "<tr>\n";
            echo "<td width=\"85%\"><span style=\"font-weight: bold\">Name: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "<span style=\"text-decoration: underline; font-weight: bold\">E-mail:</span> " . htmlentities($currMsg[1]) . "</td>\n";
            echo "<td width=\"10%\" style=\"text-align: center\">" . "<a href='MessageBoard.php?" . "action=Delete%20Message&" . "message=" . ($index - 1) . "'>" . "Delete This Message</a></td>\n";
            echo "</tr>\n";
            ++$index;
            next($keyGuestArray);
            $key = key($keyGuestArray);
        }
        echo "</table>";
    }
    ?>
    <p>
        <a href="PostGuest.php">Join as Guest</a><br>
        <a href="GuestBook.php?action=Sort%20Ascending">Sort Names A-Z</a><br>
        <a href="GuestBook.php?action=Sort%20Descending">Sort Names Z-A</a><br>
        <a href="GuestBook.php?action=Delete%20First">Delete First</a><br>
        <a href="GuestBook.php?action=Delete%20Last">Delete Last</a>
    </p>
	</body>
</html>