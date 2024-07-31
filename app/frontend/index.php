<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SBS</title>
    </head>
    <body>
        <div style="width: 100%;">
            <div style="float: right; width: fit-content; text-align: right;">
                <a href="./frontend/cart.php">Cart</a><br>
                <a href="./frontend/login.php">Login</a><br>
                <a href="./frontend/register.php">Register</a><br>
                <a href="./frontend/profile.php">Profile</a><br>
                <a href="#">Logout</a>
            </div>

            <div style="float: left; width: fit-content">
                <h1>Secure Book Store</h>
                <h2>List of available books</h2>
                <ul>
                    <?php foreach($books as $book) : ?>
                    <li>
                        <?=$book['name']; ?> - <?=$book['author']; ?>  (<?=$book['price']; ?> €)
                        <a href="#">Add to cart</a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </body>
</html>