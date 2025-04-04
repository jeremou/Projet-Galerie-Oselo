<?php
// Inclusion des fichiers nécessaires
include_once '../config/database.php';
include_once '../models/Entrepot.php';
include_once '../models/Oeuvre.php';

// Définir le chemin vers la racine
$home_path = '../';

// Instantiation de la base de données
$database = new Database();
$db = $database->getConnection();

// Instantiation de l'objet Entrepot
$entrepot = new Entrepot($db);
$oeuvre = new Oeuvre($db);

// Titre de la page
$page_title = "Gestion des Entrepôts - Galerie Oselo";

// En-tête HTML
include_once '../layout/header.php';
?>

<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-md-8">
            <h1>Gestion des Entrepôts</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="creer.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvel Entrepôt
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
            <h5 class="mb-0">Liste des Entrepôts</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Adresse</th>
                            <th>Œuvres stockées</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $entrepot->lireTout();
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                            $entrepot->id = $row['id'];
                            $oeuvres_count = $entrepot->compterOeuvres();
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nom']; ?></td>
                            <td><?php echo $row['adresse']; ?></td>
                            <td>
                                <?php if($oeuvres_count > 0): ?>
                                <a href="detail.php?id=<?php echo $row['id']; ?>">
                                    <?php echo $oeuvres_count; ?> œuvres
                                </a>
                                <?php else: ?>
                                    0 œuvres
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="modifier.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="supprimer.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet entrepôt ?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                        <?php if($stmt->rowCount() == 0): ?>
                        <tr>
                            <td colspan="5" class="text-center">Aucun entrepôt disponible</td>
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
