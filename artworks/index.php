<?php
// Inclusion des fichiers nécessaires
include_once '../config/database.php';
include_once '../models/Artwork.php';

// Définir le chemin vers la racine
$home_path = '../';

// Instantiation de la base de données
$database = new Database();
$db = $database->getConnection();

// Instantiation de l'objet Artwork
$artwork = new Artwork($db);

// Titre de la page
$page_title = "Artworks - Galerie Oselo";

// En-tête HTML
include_once '../layout/header.php';

// Récupérer les œuvres
$stmt = $artwork->readAll();
$num = $stmt->rowCount();
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Artworks</h1>
        <a href="create.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Artwork</a>
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
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Year</th>
                        <th>Dimensions</th>
                        <th>Warehouse</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['artist_name']; ?></td>
                            <td><?php echo $row['year_of_production']; ?></td>
                            <td><?php echo $row['width'] . ' x ' . $row['height'] . ' cm'; ?></td>
                            <td>
                                <?php echo $row['warehouse_id'] ? $row['warehouse_name'] : 'Not assigned'; ?>
                            </td>
                            <td>
                                <a href="assign.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info" title="Assign to warehouse"><i class="fas fa-warehouse"></i></a>
                                <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this artwork?')" title="Delete"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No artworks found.</div>
    <?php endif; ?>
</div>

<?php
// Pied de page HTML
include_once '../layout/footer.php';
?>
