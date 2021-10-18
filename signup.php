<?php
require_once 'header.php';

echo <<<_END
<script>
    function checkUser(user) {
        if (user.value == '') {
            $('#used').html('&nbsp;');
            return;
        }

        $.post('checkuser.php', { user : user.value }, function(data) {
            $('#used').html(data)
        });
    }
</script>  
_END;

$error = $user = $pass = $phone = $date = "";
if (isset($_SESSION['user'])) 
    destroySession();

if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    $phone = sanitizeString($_POST['phone']);
    $date = sanitizeString($_POST['date']);

    if ($user == "" || $pass == "" || $phone == "" || $date == "")
        $error = 'Not all fields were entered<br><br>';
    else {
        $result = queryMysql("SELECT * FROM members WHERE user='$user'");

        if ($result->num_rows)
            $error = 'That username already exists<br><br>';
        else {
            queryMysql("INSERT INTO members VALUES('$user', '$pass', '$phone', '$date' )");
            die('<h4>Account created</h4>Please Log in.</div></body></html>');
        }
    }
}

echo <<<_END
    <div class='signup'>
        <h1 class='sntitle'>Sign Up</h1>
        <h3 class='belowTitle'>We steal your data.</h3>
        <form method='post' action='signup.php'>$error

            <div data-role='fieldcontain'>
                <input class='signupInput'  placeholder='User name' type='text' maxlength='16' name='user' value='$user' onBlur='checkUser(this)>
                <label></label>
            </div>

            <div  data-role='fieldcontain'>
                <input class='signupInput' placeholder="New password" type='text' maxlength='16' name='pass' value='$pass'>
            </div>
            
            <div class='birthday' data-role='fieldcontain'>
                <h4 >Birthday</h4>
                <input class='signupInput' type="date" name='date' value='$date'>
            </div>
            <div  data-role='fieldcontain'>
                <input placeholder="Phone number" class='signupInput type='text' name='phone' value='$phone'>
            </div>
            
            <p class='tnc'>By clicking Create Account, you agree to sell us all your lamps</p>

            <div data-role='fieldcontain'>
                <label></label>
                <input class='signupBttn' data-transition='slide' type='submit' value='Create Account'>
            </div>
        </form>
    </div>
_END;
  #require_once 'footer.php';
?>
