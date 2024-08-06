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
            <li><?=$item['name']; ?> - <?=$item['author']; ?>  (<?=$item['price']; ?> €)</li><br>
            <?php endforeach; ?>
            <a><b>Shipping: </b><?php echo $shipping ?> €</a><br>
            <a><b>Total: </b><?php echo $total + $shipping ?> €</a><br><br>
        </ul>
        <h2>Shipping and Payment Info</h2>
        <form action="#">
            <label for="country">Country:</label><br>
            <input type="text" id="country" name="country"><br>
            <label for="postal_code">Postal Code:</label><br>
            <input type="text" id="postal_code" name="postal_code"><br>
            <label for="address">Full Address:</label><br>
            <input type="text" id="address" name="address"><br>
            <label for="card_number">Card number:</label><br>
            <input type="number" id="card_number" name="card_number"><br>            
            <label for="cvv">CVV:</label><br>
            <input type="number" id="cvv" name="cvv"><br>
            <label for="full_name">Card owner full name:</label><br>
            <input type="text" id="full_name" name="full_name"><br><br>
            <input type="submit" value="Buy now">
        </form>
    </body>
</html>