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
                <?php if (!isset($_SESSION['user_id'])) { ?>
                <a href="./login.php">Login</a><br>
                <a href="./register.php">Register</a><br>
                <?php } ?>
                <a href="./profile.php">Profile</a><br>
                <a href="./utils/logout.php">Logout</a>
            </div>
            <div style="float: left; width: fit-content">
                <h1>Profile</h1>
                <h2>General Info</h2>
                <ul>
                    <li><a><b>Username:</b> <?php echo $info[0]['username']; ?></a></li>
                    <li><a><b>E-mail:</b> <?php echo $info[0]['email']; ?></a></li>
                </ul>

                <h2>Purchased Books</h2>
                <ul>
                    <?php foreach($books as $book) : ?>
                    <li><a href="../backend/utils/download.php?book_id=<?php echo urlencode($book['book_id']); ?>">
                        <?php echo $book['name']; ?> - <?php echo $book['author']; ?><a> (<?php echo $book['price']; ?> €)</a>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <h2>Change Password</h2>
                <form action="../backend/profile.php" method="post">
                    <label for="current_pswd">Current password:</label><br>
                    <input type="password" id="current_pswd" name="current_pswd"><br>
                    <label for="new_pswd">New password:</label><br>
                    <input type="password" id="new_pswd" name="new_pswd"><br><br>
                    <input type="submit" value="Change password">
                </form>
            </div>
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