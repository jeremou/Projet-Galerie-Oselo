<?php
// Inclusion des fichiers nécessaires
include_once '../config/database.php';
include_once '../models/Artwork.php';

// Instantiation de la base de données
$database = new Database();
$db = $database->getConnection();

// Instantiation de l'objet Artwork
$artwork = new Artwork($db);

// Vérifier l'ID
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=Invalid artwork ID");
    exit();
}

// Récupérer l'ID et définir l'objet
$artwork->id = $_GET['id'];

// Supprimer l'œuvre
if($artwork->delete()) {
    header("Location: index.php?success=Artwork deleted successfully");
} else {
    header("Location: index.php?error=Unable to delete artwork");
}
exit();
?>
