<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : "Oselo Gallery"; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom styles -->
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #0d6efd !important;
        }
        .footer {
            margin-top: 50px;
            padding: 20px 0;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/Projet-Galerie-Oselo">Oselo Gallery</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/Projet-Galerie-Oselo">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Projet-Galerie-Oselo/artworks">Artworks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Projet-Galerie-Oselo/warehouses">Warehouses</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main content container -->
