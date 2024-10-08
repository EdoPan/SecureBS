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
                <?php if (isset($_SESSION['user_id'])) { ?>
                <a href="./profile.php">Profile</a><br>
                <!--a href="./utils/logout.php">Logout</a-->
                <form action="./utils/logout.php" method="post">
                    <input type="hidden" name="csrf" value="<?php echo generate_or_get_csrf_token(); ?>">
                    <input type="submit" value="Logout">
                </form>
                <?php } ?>
            </div>
            <div style="float: left; width: fit-content">
                <h1>Cart</h1>
                    <ol>
                        <?php foreach($items as $item) : ?>
                        <?php if(array_key_exists('message', $items)) { ?>
                        <a>
                            Message: <?=htmlspecialchars($items['message']); ?><br><br>
                        </a>
                        <?php } else { ?>
                        <li><?=htmlspecialchars($item['name']); ?> - <?=htmlspecialchars($item['author']); ?>  (<?=htmlspecialchars($item['price']); ?> €)
                        <a href="../backend/utils/manage_cart.php?id=<?php echo urlencode($item['book_id']); ?>&action=2">Remove</a>
                        </li><br>
                        <?php }; ?>
                        <?php endforeach; ?>
                        <?php if(!array_key_exists('message', $items)) { ?>
                        <p><b>Total: </b><?php echo $total; ?> €</p>
                        <button onclick="location.href='./checkout.php'">Checkout</button>
                        <?php } ?>
                    </ol>
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