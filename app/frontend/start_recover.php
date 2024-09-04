<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SBS</title>
    </head>
    <body>
        <div style="text-align: center;">
            <h1>Recover</h1>
            <form action="../backend/start_recover.php" method="post">
                <label for="email">E-mail:</label><br>
                <input type="text" id="email" name="email"><br><br>
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