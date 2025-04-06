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
$page_title = "Add New Warehouse - Galerie Oselo";

// En-tête HTML
include_once '../layout/header.php';

// Processus de création si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Définir les valeurs de l'entrepôt
    $warehouse->name = $_POST["name"];
    $warehouse->address = $_POST["address"];
    
    // Créer l'entrepôt
    if($warehouse->create()) {
        header("Location: index.php?success=Warehouse created successfully");
        exit();
    } else {
        $error_msg = "Unable to create warehouse.";
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Warehouse</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($error_msg)) echo "<div class='alert alert-danger'>{$error_msg}</div>"; ?>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Warehouse</button>
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
