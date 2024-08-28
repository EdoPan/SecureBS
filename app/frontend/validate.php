<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SBS</title>
    </head>
    <body>
        <div style="text-align: center;">
            <h1>Validate Login</h1>
            <p>We've sended to you an email with a number, please insert the number in the form to validate your profile</p>
            <form action="../backend/validate.php" method="post">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username"><br>    
                <label for="number">Number:</label><br>
                <input type="number" id="number" name="number"><br>
                <input type="submit" value="Recovery">
            </form>
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