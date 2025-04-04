<?php
// Page title
$page_title = "Home - Oselo Gallery";

// Include configuration files and models
include_once 'config/database.php';
include_once 'models/Warehouse.php';
include_once 'models/Artwork.php';

// Include HTML header
include_once 'layout/header.php';

// Database connection
$database = new Database();
$db = $database->getConnection();

// Initialize objects
$warehouse = new Warehouse($db);
$artwork = new Artwork($db);

// Get statistics
$total_warehouses = count($warehouse->readAll()->fetchAll());
$total_artworks = count($artwork->readAll()->fetchAll());
?>

<div class="container mt-4">
    <div class="jumbotron">
        <h1 class="display-4">Welcome to Oselo Gallery Admin</h1>
        <p class="lead">Manage your artworks and warehouses from this admin interface.</p>
        <hr class="my-4">
        <p>Use the menus above to access different sections.</p>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <h2><?php echo $total_artworks; ?></h2>
                            <p>Artworks</p>
                        </div>
                        <div class="col-md-6 text-center">
                            <h2><?php echo $total_warehouses; ?></h2>
                            <p>Warehouses</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="artworks/create.php" class="btn btn-primary">Add New Artwork</a>
                        <a href="warehouses/create.php" class="btn btn-secondary">Add New Warehouse</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Latest Artworks</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Artist</th>
                                    <th>Year</th>
                                    <th>Dimensions (cm)</th>
                                    <th>Warehouse</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch and display latest artworks
                                $stmt = $artwork->readLatest();
                                
                                if($stmt->rowCount() > 0) {
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                        
                                        $dimensions = $height . " × " . $width;
                                        if($depth > 0) $dimensions .= " × " . $depth;
                                        
                                        echo "<tr>";
                                        echo "<td>{$title}</td>";
                                        echo "<td>{$artist}</td>";
                                        echo "<td>{$year}</td>";
                                        echo "<td>{$dimensions}</td>";
                                        echo "<td>{$warehouse_name}</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>No artworks available</td></tr>";
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
// HTML footer
include_once 'layout/footer.php';
?>
