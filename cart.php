<?php
session_start();

include_once "db.php";

if (isset( $_GET['remove'] , $_SESSION['cart'] )) {
    $remove_id = $_GET['remove'];
    foreach( $_SESSION['cart'] as $key => $item )
    {
        if ( $item['id'] == $remove_id ) 
        {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    $_SESSION['cart'] = array_values( $_SESSION['cart'] );

    header("Location: cart.php");
    exit();
}

if ( isset( $_POST['update_cart'] ) && isset( $_SESSION['cart'] ))
 {
    foreach ( $_POST['quantity'] as $key => $value ) 
    {
        if (isset($_SESSION['cart'][$key])) 
        {
            $_SESSION['cart'][$key]['quantity'] = max(1, intval($value));
        }
    }
}

$cart_items = $_SESSION['cart'] ?? [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
</head>
<body>
    <h2>Cart</h2>
    <form action="cart.php" method="post">
        <?php if (!empty($cart_items)) : ?>
            <ul>
                <?php foreach ( $cart_items as $key => $item) : ?>
                    <li>
                        <?php echo $item['name']; ?> - Rs.<?php echo $item['price']; ?>
                        <input type="number" name="quantity[<?php echo $key; ?>]" value="<?php echo $item['quantity']; ?>" min="1">
                        <a href="cart.php?remove=<?php echo $item['id']; ?>">Remove</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <input type="submit" name="update_cart" value="Update Cart">
        <?php else : ?>
            <p>Your cart is empty</p>
        <?php endif; ?>
    </form>
    <a href="product.php">Continue Shopping</a>
</body>
</html>
