<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SBS</title>
    </head>
    <body>
        <div style="text-align: center;">
            <h1>Login</h1>
            <form action="../backend/login.php" method="post">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username"><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password"><br><br>
                <input type="submit" value="Login">
            </form>
            <p>Not registered yet? <a href="./register.php">Register</a></p>
            <p>Forgot your password? <a href="./start_recover.php">Recover</a></p>
        </div>
        <script>
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const error = urlParams.get('msg');
            if (error != undefined) {
                alert(error);
                let url = new URL(window.location);
                url.searchParams.delete('msg');
                window.location.href = url.toString();
            }
        </script>
    </body>
</html>