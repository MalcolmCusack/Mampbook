<?php
session_start();
require_once 'header.php';

echo "<h3>Welcome to $clubstr. </h3>";
echo "<div>";

if ($loggedin) 
    echo " $user, you are logged in";
else           
    require_once 'signup.php';

echo <<<_END
    </div><br>
_END;

require_once 'footer.php';
?>