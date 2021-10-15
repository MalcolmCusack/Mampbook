<?php
require_once 'header.php';

if (!$loggedin) {
    echo "<h3>Log in to view members</h3>";
    die(require 'footer.php');
}

if (isset($_GET['view'])) {
    $view = sanitizeString($_GET['view']);

    if ($view == $user)
        $name = "Your";
    else
        $name = "$view's";

    echo "<h3>$name Profile</h3>";
    showProfile($view);
    echo "<a class='followBttn' href='messages.php?view=$view'>View $name messages</a>";
    die(require 'footer.php');
}

if (isset($_GET['add'])) {
    $add = sanitizeString($_GET['add']);

    $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows)
    queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
} 
elseif (isset($_GET['remove'])) {
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
}

$result = queryMysql("SELECT user FROM members ORDER BY user");
$num    = $result->num_rows;

echo "<h3>Members: $clubstr</h3><ul>";

for ($j = 0 ; $j < $num ; ++$j) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user)
        continue;

    echo "<li class='membersLi'><a data-transition='slide' href='members.php?view=" .
    $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "follow";

    $result1 = queryMysql("SELECT * FROM friends WHERE user='" . $row['user'] . "' AND friend='$user'");
    $t1      = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM friends WHERE user='$user' AND friend='" . $row['user'] . "'");
    $t2      = $result1->num_rows;

    if (($t1 + $t2) > 1) 
        echo " is a mutual friend";
    elseif ($t1) 
        echo " you are following";
    elseif ($t2) { 
        echo " is following you";
        $follow = "Follow"; 
    }

    if (!$t1) 
        echo " <a class='followBttn' href='members.php?add=" . $row['user'] . "'>$follow</a>";
    else
        echo " <a class='followBttn' href='members.php?remove=" . $row['user'] . "'>drop</a>";
}
echo "</ul>";
require_once 'footer.php';
?>
