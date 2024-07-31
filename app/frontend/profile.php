<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SBS</title>
    </head>
    <body>
        <div style="width: 100%;">
            <div style="float: right; width: fit-content; text-align: right;">
                <a href="./cart.php">Cart</a><br>
                <a href="./login.php">Login</a><br>
                <a href="./register.php">Register</a><br>
                <a href="./profile.php">Profile</a><br>
                <a href="#">Logout</a>
            </div>
            <div style="float: left; width: fit-content">
                <h1>Profile</h1>
                <h2>General Info</h2>
                <ul>
                    <li><a><b>Username:</b> JohnWick</a></li>
                    <li><a><b>E-mail:</b> jw@localhost.com</a></li>
                </ul>

                <h2>Purchased Books</h2>
                <ul>
                    <li><a href="#">Can't Hurt Me - David Googins<a> (23.99 €)</a></a></li>
                    <li><a href="#">Atomic Habits - James Clear<a> (21.37 €)</a></a></li>
                </ul>
                <h2>Change Password</h2>
                <form action="#">
                    <label for="current_pswd">Current password:</label><br>
                    <input type="password" id="current_pswd" name="current_pswd"><br>
                    <label for="new_pswd">New password:</label><br>
                    <input type="password" id="new_pswd" name="new_pswd"><br><br>
                    <input type="submit" value="Change password">
                </form>
            </div>
        </div>
    </body>
</html>