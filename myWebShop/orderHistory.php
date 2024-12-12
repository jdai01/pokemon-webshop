<?php
// Start the session to access session variables
session_start();

// Check if username exists in session
if (!isset($_SESSION["username"])) {
    echo "<p>Please log in to view your order history.</p>";
    exit;
}

$username = $_SESSION["username"];
$orderHistoryPath = "users/$username/orderHistory.json";
$productDataPath = "json/product.json";  // Path to product.json

// Check if the order history file exists
if (!file_exists($orderHistoryPath)) {
    echo "<p>No order history found for user: $username</p>";
    exit;
}

// Load the JSON files
$orderHistory = json_decode(file_get_contents($orderHistoryPath), true);
$productData = json_decode(file_get_contents($productDataPath), true);

// Check if the JSON is valid
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "<p>Error reading order history or product data.</p>";
    exit;
}

// Create a lookup array for product images
$productImages = [];
foreach ($productData["product"] as $product) {
    $productImages[$product["pid"]] = $product["img_src"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Store - Order History</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/order-display.css">
    <link rel="stylesheet" href="styles/order-status.css">
    <script src="script/orderHistory.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <!-- Main -->
    <main>
        <h1>Your Order History</h1>

        <!-- Search for Order ID -->
        <div class="order-search container">
            <label for="searchOrderID">Search Order ID:</label>
            <input type="text" id="searchOrderID" placeholder="Enter Order ID" />
        </div>

        <!-- Order Display -->
        <div class="order-display container" id="order-display">
            <?php foreach ($orderHistory as $order): ?>
            <div class="box order-display-box">
                <div class="container">
                    <div class="left">
                        <strong>Order ID: <?php echo htmlspecialchars($order["orderID"]); ?></strong>
                        <p>Date: <?php echo htmlspecialchars($order["datetime"]); ?></p>
                    </div>
                    <div class="right">
                        <strong
                            class="<?php echo strtolower($order["status"]) === "completed" ? 'status-completed' : (in_array(strtolower($order["status"]), ['cancelled', 'returned']) ? 'status-cancelled-returned' : ''); ?>">
                            <?php echo htmlspecialchars(ucfirst($order["status"])); ?>
                        </strong>
                        <p>Total Price: <?php echo htmlspecialchars(number_format($order["totalPrice"], 2)); ?> €</p>
                    </div>
                </div>

                <!-- Order Product Images -->
                <div class="order-product-items">
                    <?php foreach ($order["cart"] as $item): ?>
                    <?php if (isset($productImages[$item["pid"]])): ?>
                    <div class="order-product-item">
                        <p class="order-qty"><?php echo htmlspecialchars($item["qty"]); ?></p>
                        <img src="<?php echo htmlspecialchars($productImages[$item["pid"]]); ?>" alt="Product Image" />
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>


                <div style="display: flex; justify-content: center;">
                    <a href="order.php?orderID=<?php echo urlencode($order['orderID']); ?>">
                        <button>View Order</button>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>