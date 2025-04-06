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
$page_title = "Assign Artwork to Warehouse - Galerie Oselo";

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

// Processus d'assignation si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Définir l'entrepôt
    $artwork->warehouse_id = !empty($_POST["warehouse_id"]) ? $_POST["warehouse_id"] : NULL;
    
    // Assigner l'œuvre à l'entrepôt
    if($artwork->assignToWarehouse()) {
        header("Location: index.php?success=Artwork assigned to warehouse successfully");
        exit();
    } else {
        $error_msg = "Unable to assign artwork to warehouse.";
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5>Assign Artwork to Warehouse</h5>
                </div>
                <div class="card-body">
                    <?php if(isset($error_msg)) echo "<div class='alert alert-danger'>{$error_msg}</div>"; ?>
                    
                    <h4><?php echo $artwork->title; ?></h4>
                    <p>Artist: <?php echo $artwork->artist_name; ?></p>
                    <p>Current warehouse: <?php echo $artwork->warehouse_id ? 'Assigned' : 'Not assigned'; ?></p>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?id=' . $artwork->id); ?>" method="post">
                        <div class="mb-3">
                            <label for="warehouse_id" class="form-label">Select Warehouse</label>
                            <select class="form-select" id="warehouse_id" name="warehouse_id">
                                <option value="">Not Assigned</option>
                                <?php 
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                                    $selected = ($row['id'] == $artwork->warehouse_id) ? 'selected' : '';
                                ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Assign to Warehouse</button>
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
