<?php
require_once 'header.php';
$error = $user = $pass = "";

if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
        $error = 'Not all fields were entered';
    else {
        $result = queryMySQL("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");

        if ($result->num_rows == 0) {
            $error = "Invalid login attempt";
        }
        else {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            die("<h3>Welcome back, $user.</h3><p>Please <a href='members.php?view=$user'>click here</a> to continue.</p></div><footer></footer></body></html>");
        }
    }
}

echo <<<_END

    <form class="loginForm" method='post' action='login.php'>
        <div data-role='fieldcontain'>
            <label></label>
            <span class='error'>$error</span>
        </div>
        <div class="loginDiv" data-role='fieldcontain'>
            <label>Username</label>
            <input type='text' maxlength='16' name='user' value='$user'>
        </div>
        <div class="loginDiv" data-role='fieldcontain'>
            <label>Password</label>
            <input type='password' maxlength='16' name='pass' value='$pass'>
        </div>
        <div class="buttonDiv" data-role='fieldcontain'>
            <label></label>
            <input data-transition='slide' type='submit' value='Log In'>
        </div>
    </form>
_END;
?>
