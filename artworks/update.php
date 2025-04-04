<?php
// Inclusion des fichiers nécessaires
include_once '../config/database.php';
include_once '../models/Artwork.php';
include_once '../models/Warehouse.php';

// Définir le chemin vers la racine
$home_path = '../';

// Instantiation de la base de données
$database = new Database();
$db = $database->getConnection();

// Instantiation des objets
$artwork = new Artwork($db);
$warehouse = new Warehouse($db);

// Titre de la page
$page_title = "Update Artwork - Galerie Oselo";

// En-tête HTML
include_once '../layout/header.php';

// Vérifier l'ID
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=Invalid artwork ID");
    exit();
}

// Récupérer l'ID et définir l'objet
$artwork->id = $_GET['id'];

// Lire les détails de l'œuvre
if(!$artwork->readOne()) {
    header("Location: index.php?error=Artwork not found");
    exit();
}

// Récupérer la liste des entrepôts pour le dropdown
$stmt = $warehouse->readAll();

// Processus de mise à jour si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Définir les valeurs de l'œuvre
    $artwork->title = $_POST["title"];
    $artwork->year_of_production = $_POST["year_of_production"];
    $artwork->artist_name = $_POST["artist_name"];
    $artwork->width = $_POST["width"];
    $artwork->height = $_POST["height"];
    $artwork->warehouse_id = !empty($_POST["warehouse_id"]) ? $_POST["warehouse_id"] : NULL;
    
    // Mettre à jour l'œuvre
    if($artwork->update()) {
        header("Location: index.php?success=Artwork updated successfully");
        exit();
    } else {
        $error_msg = "Unable to update artwork.";
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5>Update Artwork</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($error_msg)) echo "<div class='alert alert-danger'>{$error_msg}</div>"; ?>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $artwork->id); ?>" method="post">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type
