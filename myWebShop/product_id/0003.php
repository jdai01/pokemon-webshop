<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venusaur #0003</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script src="../script/collection-list.js" defer></script>
</head>

<body>
    <!-- Header -->
    <header>
        <iframe src="../header.php" class="header-iframe"></iframe>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Wrap the main content in a flex container -->
        <div class="main-content">
            <div class="main">
                <div class="info">
                    <h1>Venusaur #0003</h1>
                    <img src="https://www.pokemon.com/static-assets/content-assets/cms2/img/pokedex/full/003.png"
                        width="200px">
                    <p>While it basks in the sun, it can convert the light into energy. As a result, it is more powerful
                        in the summertime.</p>
                </div>
                <div class="cart">
                    <h2>Price: 20€</h2>
                    <div class="item-selection">
                        <input type="number" class="quantity-input" id="quantity" value="1" min="1">
                        <button class="add-to-collection">Add to Collection List</button>
                    </div>
                </div>
            </div>

            <!-- Description and stats in flex layout -->
            <div class="description">
                <h2>Description:</h2>
                <ul>
                    <li>Height: 6' 07"</li>
                    <li>Weight: 220.5 lbs</li>
                    <li>Gender: Male & Female</li>
                    <li><a href="../categoryList/categories/categoryList.php">Category</a>: <a
                            href="../categoryList/categories/seed.php">Seed</a></li>
                    <li>Abilities: Overgrow</li>
                </ul>

                <h2><a href="../categoryList/types/typeList.php">Type</a></h2>
                <ul>
                    <li><a href="../categoryList/types/grass.php">Grass</a></li>
                    <li><a href="../categoryList/types/poison.php">Poison</a></li>
                </ul>

                <h2>Weakness</h2>
                <ul>
                    <li>Fire</li>
                    <li>Ice</li>
                    <li>Flying</li>
                    <li>Psychic</li>
                </ul>
            </div>

            <div class="stats">
                <h2>Stats</h2>
                <ul>
                    <li>HP: 5/10</li>
                    <li>Attack: 5/10</li>
                    <li>Defense: 5/10</li>
                    <li>Special Attack: 6/10</li>
                    <li>Special Defense: 6/10</li>
                    <li>Speed: 6/10</li>
                </ul>

                <h2>Evolution</h2>
                <ol>
                    <li><a href="0001.php">Bulbasaur #0001</a></li>
                    <li><a href="0002.php">Ivysaur #0002</a></li>
                    <li><a href="0003.php">Venusaur #0003</a> (current)</li>
                </ol>
            </div>
        </div>

        <iframe src="collection-list.php" class="collection-list-iframe"></iframe>

        <hr>
        <a href="../categoryList/mainList.php">Back to category list</a><br>
        <a href="../index.php">Back to main page</a><br>
    </main>

    <!-- Footer -->
    <footer>
        <iframe src="../footer.php" class="footer-iframe"></iframe>
    </footer>
</body>

</html>