<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SBS</title>
    </head>
    <body>
        <div style="text-align: center;">
            <h1>Change password</h1>
            <p>We've sended to you an email with a number, please insert the number in the form to change your password</p>
            <form action="../backend/change_pwd.php" method="post">
                <label for="number">Number:</label><br>
                <input type="number" id="number" name="number"><br>
                <input type="hidden" name="csrf" value="<?php echo generate_or_get_csrf_token(); ?>">
                <input type="submit" value="Change">
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