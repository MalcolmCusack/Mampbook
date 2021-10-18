<?php
//session_start();

$clubstr = 'Lampbook';
$userstr = 'Welcome to Lampbook.';

echo <<<_INIT
<!DOCTYPE html> 
<html>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'> 
        <link rel='stylesheet' href='css/styles.css'>
        <script src='javascript.js'></script>
        <script src='spacephoto.js'></script>
        <link href="https://fonts.googleapis.com/css?family=PTSansNarrow|Lora|Muli|Source+Sans+Pro|Playfair+Display&display=swap" rel="stylesheet">
        <title>$clubstr: $userstr</title>
        </head>
_INIT;

require_once 'functions.php';

if (isset($_SESSION['user'])) {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = "Logged in as: $user";
}
else $loggedin = FALSE;

echo <<<_HEADER_OPEN
    
    <body>
        <div id="wrapper">
        <header>
            <img class="headerImg" src="https://cdn.icon-icons.com/icons2/2248/PNG/512/desk_lamp_icon_136702.png"/>
            <div id='logo'>$clubstr</div>

_HEADER_OPEN;

if (!$loggedin) {
    require_once 'login.php';
}


if ($loggedin) {
echo <<<_LOGGEDIN

            <nav><ul>
                <li><a href='members.php?view=$user'>Home</a></li>
                <li><a href='members.php'>Members</a></li>
                <li><a href='friends.php'>Friends</a></li>
                <li><a href='messages.php'>Messages</a></li>
                <li><a href='profile.php'>Edit Profile</a></li>
                <li><a href='spacephoto.php'>Photo Of The Day</a></li>
                <li><a href='flappybird.html'>Flappy Bird</a></li>
                <li><a href='logout.php'>Log out</a></li>
                
                <li></li>
            </ul></nav>
_LOGGEDIN;
} else {
echo <<<_GUEST

            <nav><ul>
                <li><a href='index.php'>Home</a></li>
                <li><a href='spacephoto.php'>Photo Of The Day</a></li>
                <li><a href='flappybird.html'>Flappy Bird</a></li>
            </ul></nav>
_GUEST;
 }

echo <<<_HEADER_CLOSE

        </header>
        <div class='username'>$userstr</div>
        <div id="content">
_HEADER_CLOSE;

?>
