<?php
// Inclusion des fichiers nécessaires
include_once 'config/database.php';
include_once 'models/Artwork.php';
include_once 'models/Warehouse.php';

// Instantiation de la base de données
$database = new Database();
$db = $database->getConnection();

// Instantiation des objets
$artwork = new Artwork($db);
$warehouse = new Warehouse($db);

// Titre de la page
$page_title = "Galerie Oselo - Administration";

// En-tête HTML
include_once 'layout/header.php';
?>

<div class="container mt-5">
    <div class="jumbotron">
        <h1 class="display-4">Welcome to Galerie Oselo</h1>
        <p class="lead">Administration panel for managing artworks and warehouses</p>
        <hr class="my-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Artworks Management</h5>
                    </div>
                    <div class="card-body">
                        <p>Manage all the paintings in the gallery</p>
                        <a href="artworks/index.php" class="btn btn-primary">View Artworks</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Warehouses Management</h5>
                    </div>
                    <div class="card-body">
                        <p>Manage storage locations for the artworks</p>
                        <a href="warehouses/index.php" class="btn btn-primary">View Warehouses</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Pied de page HTML
include_once 'layout/footer.php';
?>
