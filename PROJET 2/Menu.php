<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>KUNG FOOD - Menu</title>
        <link rel="stylesheet" href="CSS/styleMenu.css">
        <link rel="stylesheet" href="CSS/BarreNav.css">
        <link rel="stylesheet" href="CSS/Recherche.css">
        <link rel="stylesheet" href="CSS/Variable.css">
    </head>
    <body>
        <?php include 'section/Navigation.php'; ?>

        <div class="effetNoir">
                <section class="PosBarre">
                    <div class="Titre">
                        <h1>Presentation des plats</h1>
                    </div>
                        <?php include 'section/BarreMenu.php'; ?>
                </section>
            <section class="Menu">
                <div class="MenuGrid">
                    <?php include 'section/plat.php'; ?>
                </div>
            </section>
        </div>
    </body>
</html>