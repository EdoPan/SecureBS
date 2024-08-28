<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>SBS</title>
</head>

<body>
    <div style="width: 100%;">
        <div style="float: right; width: fit-content; text-align: right;">
            <a href="./backend/cart.php">Cart</a><br>
            <a href="./backend/login.php">Login</a><br>
            <a href="./backend/register.php">Register</a><br>
            <a href="./backend/profile.php">Profile</a><br>
            <a href="./backend/logout.php">Logout</a>
        </div>

        <div style="float: left; width: fit-content">
            <h1>Secure Book Store</h>
                <h2>List of available books</h2>
                <ul>
                    <h3>Name - Author - Price - Quantity</h3>
                    <?php foreach ($books as $book): ?>
                        <?php if (array_key_exists('message', $books)) { ?>
                            <a>
                                Message: <?= $books['message']; ?>
                            </a>
                        <?php } else { ?>
                            <li>
                                <?= $book['name']; ?> - <?= $book['author']; ?> (<?= $book['price']; ?> €)
                                [<?= $book['quantity']; ?>]
                                <?php if ($book['quantity'] != 0) { ?>
                                    <a href="./backend/utils/manage_cart.php?id=<?php echo urlencode($book['id']); ?>&action=1">Add
                                        to cart</a>
                                <?php }
                                ; ?>
                            </li>
                        <?php }
                        ; ?>
                    <?php endforeach; ?>
                </ul>
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