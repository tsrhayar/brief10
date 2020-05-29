<div class="parent-navbar">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">YouSHOP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav" id="navone">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Acceuil</a>
                </li>
                <?php
                // echo $row;
                if (isset($_SESSION['admin'])) { ?>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="members.php">Membres</a>
                    </li> -->
                <?php }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="products.php">Produits</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="commande.php">Commande</a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        mon compte
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php
                        if (isset($_SESSION['admin'])) {
                            echo '<a class="dropdown-item" href="members.php">Gestions des membres</a>';
                            echo '<a class="dropdown-item" href="manageproducts.php">Gestions des produits</a>';
                        }
                        ?>

                        <a class="dropdown-item" href="logout.php">Se déconnecter</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
