<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Category</title>
    <link rel="stylesheet" href="../../styles/first-style.css">
    <link rel="stylesheet" href="../../styles/forms.css">
    <link rel="stylesheet" href="../../styles/mystyle.css">
</head>
<body>
    <!-- Header -->
    <header>
        <iframe src="../../header.php" class="header-iframe"></iframe>
    </header>
    
    <main>
        <h1>Pokémon Category</h1>
        <p>This is a Pokédex webpage designed to provide detailed information about various Pokémon, categorized by category.</p>

        <table>
            <thead>
                <tr>
                    <td><a href="categoryList.php">Category</a></td>
                    <td>Pokémons</td>
                </tr>
            </thead>
            <tbody>
                <!-- Seed -->
                <tr>
                    <td><a href="seed.php">Seed</a><br></td>
                    <td>
                        <ul>
                            <li><a href="../../product_id/detail.php?pid=0001">Bulbasaur #0001</a></li>
                            <li><a href="../../product_id/detail.php?pid=0002">Ivysaur #0002</a></li>
                            <li><a href="../../product_id/detail.php?pid=0003">Venusaur #0003</a></li>
                        </ul>
                    </td>
                </tr>
                <!-- Tiny Turtle -->
                <tr>
                    <td><a href="tiny-turtle.php">Tiny Turtle</a><br></td>
                    <td>
                        <ul>
                            <li><a href="../../product_id/detail.php?pid=0007">Squirtle #0007</a></li>
                        </ul>
                    </td>
                </tr>
                <!-- Turtle -->
                <tr>
                    <td><a href="turtle.php">Turtle</a><br></td>
                    <td>
                        <ul>
                            <li><a href="../../product_id/detail.php?pid=0008">Wartortle #0008</a></li>
                        </ul>
                    </td>
                </tr>
                <!-- Shellfish -->
                <tr>
                    <td><a href="shellfish.php">Shellfish</a><br></td>
                    <td>
                        <ul>
                            <li><a href="../../product_id/detail.php?pid=0009">Blastoise #0009</a></li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <hr>
        <a href="../mainList.php">Back to category list</a><br>
        <a href="../../index.php">Back to main page</a><br>
    </main>

    <!-- Footer -->
    <footer>
        <iframe src="../../footer.php" class="footer-iframe"></iframe>
    </footer>
</body>
</html>
