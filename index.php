<?php
// Titre de la page
$page_title = "Accueil - Galerie Oselo";

// Inclure les fichiers de configuration et les modèles
include_once 'config/database.php';
include_once 'models/Entrepot.php';
include_once 'models/Oeuvre.php';

// Inclure l'en-tête HTML
include_once 'layout/header.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Initialiser les objets
$entrepot = new Entrepot($db);
$oeuvre = new Oeuvre($db);

// Récupérer les statistiques
$total_entrepots = count($entrepot->lireTout()->fetchAll());
$total_oeuvres = count($oeuvre->lireTout()->fetchAll());
?>

<div class="container mt-4">
    <div class="jumbotron">
        <h1 class="display-4">Bienvenue sur l'administration de la Galerie Oselo</h1>
        <p class="lead">Gérez vos œuvres et vos entrepôts depuis cette interface d'administration.</p>
        <hr class="my-4">
        <p>Utilisez les menus ci-dessus pour accéder aux différentes sections.</p>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <h2><?php echo $total_oeuvres; ?></h2>
                            <p>Œuvres dans la collection</p>
                            <a href="oeuvres/index.php" class="btn btn-outline-primary">Gérer les œuvres</a>
                        </div>
                        <div class="col-md-6 text-center">
                            <h2><?php echo $total_entrepots; ?></h2>
                            <p>Entrepôts disponibles</p>
                            <a href="entrepots/index.php" class="btn btn-outline-primary">Gérer les entrepôts</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="oeuvres/creer.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-plus-circle me-2"></i> Ajouter une nouvelle œuvre
                        </a>
                        <a href="entrepots/creer.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-plus-circle me-2"></i> Ajouter un nouvel entrepôt
                        </a>
                        <a href="oeuvres/assigner.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-exchange-alt me-2"></i> Assigner une œuvre à un entrepôt
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" onclick="alert('Fonctionnalité en développement')">
                            <i class="fas fa-search me-2"></i> Rechercher dans la collection
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">Dernières œuvres ajoutées</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Artiste</th>
                                    <th>Année</th>
                                    <th>Dimensions</th>
                                    <th>Entrepôt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $oeuvre->lireDernieres(5);
                                
                                if($stmt->rowCount() > 0) {
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        // Récupérer le nom de l'entrepôt
                                        $entrepot_nom = "Non assigné";
                                        if(!is_null($row['entrepot_id'])) {
                                            $entrepot->id = $row['entrepot_id'];
                                            if($entrepot->lireUn()) {
                                                $entrepot_nom = $entrepot->nom;
                                            }
                                        }
                                        
                                        echo "<tr>";
                                        echo "<td>{$row['titre']}</td>";
                                        echo "<td>{$row['nom_artiste']}</td>";
                                        echo "<td>{$row['annee_production']}</td>";
                                        echo "<td>{$row['largeur']} × {$row['hauteur']} cm</td>";
                                        echo "<td>{$entrepot_nom}</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>Aucune œuvre disponible</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Pied de page HTML
include_once 'layout/footer.php';
?>
