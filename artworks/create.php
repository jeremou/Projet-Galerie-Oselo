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
$page_title = "Add New Artwork - Galerie Oselo";

// En-tête HTML
include_once '../layout/header.php';

// Récupérer la liste des entrepôts pour le dropdown
$stmt = $warehouse->readAll();

// Processus de création si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Définir les valeurs de l'œuvre
    $artwork->title = $_POST["title"];
    $artwork->year_of_production = $_POST["year_of_production"];
    $artwork->artist_name = $_POST["artist_name"];
    $artwork->width = $_POST["width"];
    $artwork->height = $_POST["height"];
    $artwork->warehouse_id = !empty($_POST["warehouse_id"]) ? $_POST["warehouse_id"] : NULL;
    
    // Créer l'œuvre
    if($artwork->create()) {
        header("Location: index.php?success=Artwork created successfully");
        exit();
    } else {
        $error_msg = "Unable to create artwork.";
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5>Add New Artwork</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($error_msg)) echo "<div class='alert alert-danger'>{$error_msg}</div>"; ?>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="artist_name" class="form-label">Artist Name</label>
                            <input type="text" class="form-control" id="artist_name" name="artist_name">
                        </div>
                        
                        <div class="mb-3">
                            <label for="year_of_production" class="form-label">Year of Production</label>
                            <input type="number" class="form-control" id="year_of_production" name="year_of_production" min="1" max="<?php echo date("Y"); ?>">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="width" class="form-label">Width (cm)</label>
                                    <input type="number" class="form-control" id="width" name="width" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="height" class="form-label">Height (cm)</label>
                                    <input type="number" class="form-control" id="height" name="height" step="0.01" min="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="warehouse_id" class="form-label">Warehouse</label>
                            <select class="form-select" id="warehouse_id" name="warehouse_id">
                                <option value="">Not Assigned</option>
                                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Artwork</button>
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
