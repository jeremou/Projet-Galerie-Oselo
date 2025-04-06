<?php
// Inclusion des fichiers nécessaires
include_once '../config/database.php';
include_once '../models/Warehouse.php';

// Instantiation de la base de données
$database = new Database();
$db = $database->getConnection();

// Instantiation de l'objet Warehouse
$warehouse = new Warehouse($db);

// Vérifier l'ID
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=Invalid warehouse ID");
    exit();
}

// Récupérer l'ID et définir l'objet
$warehouse->id = $_GET['id'];

// Supprimer l'entrepôt et désassigner les œuvres
if($warehouse->delete()) {
    header("Location: index.php?success=Warehouse deleted successfully and artworks unassigned");
} else {
    header("Location: index.php?error=Unable to delete warehouse");
}
exit();
?>
