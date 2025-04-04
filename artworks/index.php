<?php
// Inclusion des fichiers nécessaires
include_once '../config/database.php';
include_once '../models/Oeuvre.php';

// Définir le chemin vers la racine
$home_path = '../';

// Instantiation de la base de données
$database = new Database();
$db = $d atabase->getConnection();

// Instantiation de l'objet Oeuvre
$oeuvre = new Oeuvre($db);

// Titre de la page
$page_title = "Gestion des Œuvres - Galerie Oselo";

// En-tête HTML
include_once '../layout/header.php';
?>

<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h1>Gestion des Œuvres</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="creer.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvelle Œuvre
            </a>
        </div>
    </div>
    
    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
    <?php endif; ?>
    
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?php echo $_GET['error']; ?></div>
    <?php endif; ?>
    
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Liste des Œuvres</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Artiste</th>
                            <th>Année</th>
                            <th>Dimensions (cm)</th>
                            <th>Entrepôt</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $oeuvre->lireTout();
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['titre']; ?></td>
                            <td><?php echo $row['nom_artiste']; ?></td>
                            <td><?php echo $row['annee_production']; ?></td>
                            <td><?php echo $row['largeur'] . ' x ' . $row['hauteur']; ?></td>
                            <td><?php echo $row['nom_entrepot'] ? $row['nom_entrepot'] : 'Non assigné'; ?></td>
                            <td>
                                <a href="modifier.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="supprimer.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette œuvre ?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                        <?php if($stmt->rowCount() == 0): ?>
                        <tr>
                            <td colspan="7" class="text-center">Aucune œuvre disponible</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
// Pied de page HTML
include_once '../layout/footer.php';
?>
 