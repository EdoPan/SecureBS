<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>SBS</title>
</head>

<body>
    <div style="text-align: center;">
        <h1>Register</h1>
        <form action="../backend/register.php" method="post">
            <label for="email">E-mail:</label><br>
            <input type="text" id="email" name="email"><br>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <label for="pswd">Confirm password:</label><br>
            <input type="password" id="pswd" name="pswd"><br><br>
            <input type="submit" value="Register">
        </form>
        <p>Already registered? <a href="./login.php">Login</a></p>
    </div>
    <script>
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const error = urlParams.get('msg');
        if (error != undefined) {
            alert(error);
        }
    </script>
</body>

</html>