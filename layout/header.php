<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? "Galerie Oselo - Administration"; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Font: Lato -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            font-family: 'Lato', sans-serif;
        }
        
        .navbar {
            background-color: #4E598C !important;
        }
        
        .btn-primary {
            background-color: #4E598C;
            border-color: #4E598C;
        }
        
        .btn-primary:hover {
            background-color: #3a4268;
            border-color: #3a4268;
        }
        
        .accent-color {
            color: #F9C784;
        }
        
        .card-header {
            background-color: #4E598C;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $home_path ?? ''; ?>index.php">
                Galerie Oselo <span class="accent-color">Admin</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $home_path ?? ''; ?>oeuvres/index.php">Œuvres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $home_path ?? ''; ?>entrepots/index.php">Entrepôts</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
