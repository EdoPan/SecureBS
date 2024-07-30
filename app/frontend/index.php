<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SBS</title>
    </head>
    <body>
        <h1>Secure Book Store</h>
        <h2>List of available books</h2>
        <ul>
            <?php foreach($books as $book) : ?>
            <a>
                Name: <?=$book['name']; ?> Author: <?=$book['author']; ?> Price: <?=$book['price']; ?>€
            </a>
            <br>
            <?php endforeach; ?>
        </ul>
    </body>
</html>