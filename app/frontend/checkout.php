<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SBS</title>
    </head>
    <body>
        <h1>Checkout</h1>
        <h2>Articles</h2>
        <ul>
            <?php foreach($items as $item) : ?>
            <li><?=htmlspecialchars($item['name']); ?> - <?=htmlspecialchars($item['author']); ?>  (<?=htmlspecialchars($item['price']); ?> €)</li><br>
            <?php endforeach; ?>
            <a><b>Shipping: </b><?php echo $shipping ?> €</a><br>
            <a><b>Total: </b><?php echo $total + $shipping ?> €</a><br><br>
        </ul>
        <h2>Shipping and Payment Info</h2>
        <form action="../backend/checkout.php" method="post">
            <label for="country">Country:</label><br>
            <input type="text" id="country" name="country"><br>
            <label for="postal_code">Postal Code:</label><br>
            <input type="text" id="postal_code" name="postal_code"><br>
            <label for="city">City:</label><br>
            <input type="text" id="city" name="city"><br>
            <label for="full_address">Full Address:</label><br>
            <input type="text" id="full_address" name="full_address"><br>
            <label for="card_number">Card number:</label><br>
            <input type="number" id="card_number" name="card_number"><br>            
            <label for="cvv">CVV:</label><br>
            <input type="number" id="cvv" name="cvv"><br>
            <label for="card_owner">Card owner full name:</label><br>
            <input type="text" id="card_owner" name="card_owner"><br><br>
            <input type="hidden" name="csrf" value="<?php echo generate_or_get_csrf_token(); ?>">
            <input type="submit" value="Buy now">
        </form>
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