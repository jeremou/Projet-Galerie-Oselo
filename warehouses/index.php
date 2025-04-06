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
$page_title = "Warehouses - Galerie Oselo";

// En-tête HTML
include_once '../layout/header.php';

// Récupérer les entrepôts
$stmt = $warehouse->readAll();
$num = $stmt->rowCount();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Warehouses</h1>
        <a href="create.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Warehouse</a>
    </div>
    
    <?php
    // Affichage du message de succès ou d'erreur s'il existe
    if(isset($_GET['success'])) {
        echo '<div class="alert alert-success">' . $_GET['success'] . '</div>';
    }
    if(isset($_GET['error'])) {
        echo '<div class="alert alert-danger">' . $_GET['error'] . '</div>';
    }
    ?>
    
    <?php if($num > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Artworks Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                        $warehouse->id = $row['id'];
                        $artworksCount = $warehouse->countArtworks();
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $artworksCount; ?></td>
                            <td>
                                <a href="../artworks/index.php?warehouse_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info" title="View artworks"><i class="fas fa-box-open"></i></a>
                                <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this warehouse? All artworks will be unassigned.')" title="Delete"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No warehouses found.</div>
    <?php endif; ?>
</div>

<?php
// Pied de page HTML
include_once '../layout/footer.php';
?>
