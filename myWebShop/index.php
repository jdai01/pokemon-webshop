<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Store</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="script/extra-function2.js"></script>

</head>

<body>
    <!-- Header -->
    <header>
        <iframe src="header.php" class="header-iframe"></iframe>
    </header>

    <!-- Main -->
    <main>
        <?php
            $welcomeMessage = "Welcome to Our Pokémon Store!";
            $shopDescription = "We offer a wide variety of Pokémon-themed products to suit your needs.";
        ?>
        <h1><?php echo $welcomeMessage; ?></h1>
        <p><?php echo $shopDescription; ?></p>

        <button id="i-choose-you">I Choose You! <img src="img/pokeball.png" width="30px" alt="PokeBall"></button>

        <h2><a href="categoryList/mainList.php">Categories</a></h2>
        <ul class="menu">

            <li><a href="categoryList/types/typeList.php">Types:</span>
                    <ul class="submenu">
                        <li>
                            <a href="categoryList/types/grass.php">
                                Grass <img src="https://www.serebii.net/pokedex-sv/type/icon/grass.png" width="20px"
                                    alt="Grass Icon" class="type-icon">
                            </a>
                        </li>
                        <li>
                            <a href="categoryList/types/poison.php">
                                Poison <img src="https://www.serebii.net/pokedex-sv/type/icon/poison.png" width="20px"
                                    alt="Poison Icon" class="type-icon">
                            </a>
                        </li>
                        <li>
                            <a href="categoryList/types/water.php">
                                Water <img src="https://www.serebii.net/pokedex-sv/type/icon/water.png" width="20px"
                                    alt="Water Icon" class="type-icon">
                            </a>
                        </li>
                    </ul>
            </li>


            <li><a href="categoryList/categories/categoryList.php">Category:</span>
                    <ul class="submenu">
                        <li><a href="categoryList/categories/seed.php">Seed</a></li>
                        <li><a href="categoryList/categories/tiny-turtle.php">Tiny-turtle</a></li>
                        <li><a href="categoryList/categories/turtle.php">Turtle</a></li>
                        <li><a href="categoryList/categories/shellfish.php">Shellfish</a></li>
                    </ul>
            </li>
        </ul>
    </main>


    <!-- Footer -->
    <footer>
        <iframe src="footer.php" class="footer-iframe"></iframe>
    </footer>
</body>

</html>