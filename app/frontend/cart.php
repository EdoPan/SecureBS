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
                <a href="./logout.php">Logout</a>
            </div>
            <div style="float: left; width: fit-content">
                <h1>Cart</h1>
                <form action="#">
                    <ol>
                        <?php foreach($items as $item) : ?>
                        <?php if(array_key_exists('message', $items)) { ?>
                        <a>
                            Message: <?=$items['message']; ?><br><br>
                        </a>
                        <?php } else { ?>
                        <li><?=$item['name']; ?> - <?=$item['author']; ?>  (<?=$item['price']; ?> €)</li><br>
                        <input type="submit" value="Checkout">
                        <?php }; ?>
                        <?php endforeach; ?>
                    </ol>
                </form>
            </div>
        </div>
    </body>
</html>