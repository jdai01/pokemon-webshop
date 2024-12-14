<?php
// Start the session to access session variables
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Store</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/darkmode.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/main.css">

    <!-- JavaScript -->
    <script src="script/extra-function2.js"></script>
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <!-- Main Content -->
    <main class="welcome">
        <div class="info-board">
            <h1>
                <?php
                if (isset($_SESSION['username']) && $_SESSION['username']) {
                    echo "Welcome back, " . htmlspecialchars($_SESSION['firstName']) . "!";
                } else {
                    echo "Welcome to Our Pokémon Store!";
                }
                ?>
            </h1>
            <p>We offer a wide variety of Pokémon-themed products to suit your needs.</p>

            <div class="container">
                <button id="i-choose-you" class="btn btn-pastel-blue">
                    I Choose You!
                    <img src="img/pokeball.png" width="10%" alt="PokeBall">
                </button>
                <a href="all-products.php">
                    <button class="btn btn-pastel-blue">View All Products</button>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>