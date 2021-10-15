<?php
$dbhost  = 'localhost';

$dbname  = 'db10';   // Modify these...
$dbuser  = 'user10';   // ...variables according
$dbpass  = '10rodi';   // ...to your installation


$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) 
    die("Fatal Error 1");

function createTable($name, $query){
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists.<br>";
}

$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_ALL;

function queryMysql($query) {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die("Fatal Error 2");
    return $result;
}

function destroySession() {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}


function sanitizeString($var){
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    //if (get_magic_quotes_gpc())
    //    $var = stripslashes($var);
    return $connection->real_escape_string($var);
}

function showProfile($user) {
    if (file_exists("userpics/$user.jpg"))
        echo "<img class='userpic' src='userpics/$user.jpg'>";

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
    }
    else echo "<p>Nothing to see here, yet</p><br>";
}

function callAPI($url, $data) {
    $curl = curl_init();

    if ($data) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    } else {
        curl_setopt($curl, CURLOPT_PUT, 1);

    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    echo $result;
    curl_close($curl);

    return $result;  
}

function getAPI($url) {
    $response = file_get_contents($url);
    $response = json_decode($response);
    echo "hit" + $response;
    return $response;
}

?>
