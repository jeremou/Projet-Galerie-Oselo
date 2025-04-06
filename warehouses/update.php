<?php
// Inclusion des fichiers nécessaires
include_once '../config/database.php';
include_once '../models/Warehouse.php';

// Définir le chemin vers la racine
$home_path = '../';

// Instantiation de la base de données
$database = new Database();
$db = $database->getConnection();

// Instantiation de l'objet Warehouse
$warehouse = new Warehouse($db);

// Titre de la page
$page_title = "Update Warehouse - Galerie Oselo";

// En-tête HTML
include_once '../layout/header.php';

// Vérifier l'ID
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?error=Invalid warehouse ID");
    exit();
}

// Récupérer l'ID et définir l'objet
$warehouse->id = $_GET['id'];

// Lire les détails de l'entrepôt
if(!$warehouse->readOne()) {
    header("Location: index.php?error=Warehouse not found");
    exit();
}

// Processus de mise à jour si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Définir les valeurs de l'entrepôt
    $warehouse->name = $_POST["name"];
    $warehouse->address = $_POST["address"];
    
    // Mettre à jour l'entrepôt
    if($warehouse->update()) {
        header("Location: index.php?success=Warehouse updated successfully");
        exit();
    } else {
        $error_msg = "Unable to update warehouse.";
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5>Update Warehouse</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($error_msg)) echo "<div class='alert alert-danger'>{$error_msg}</div>"; ?>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $warehouse->id); ?>" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $warehouse->name; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"><?php echo $warehouse->address; ?></textarea>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Warehouse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Pied de page HTML
include_once '../layout/footer.php';
?>
