<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SBS</title>
    </head>
    <body>
        <div style="text-align: center;">
            <h1>Recover</h1>
            <p>We've sent you and email with a number, please insert the number and the new password</p>
            <form action="../backend/recover_pwd.php" method="post">
                <label for="number">Number:</label><br>
                <input type="text" id="number" name="number"><br><br>
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username"><br><br>
                <label for="pwd">Password:</label><br>
                <input type="password" id="pwd" name="pwd"><br><br>
                <label for="new_pwd">Repeat Password:</label><br>
                <input type="password" id="new_pwd" name="new_pwd"><br><br>
                <input type="submit" value="Recover">
            </form>
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