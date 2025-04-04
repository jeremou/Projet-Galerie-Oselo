<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Galerie Oselo'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts - Lato -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
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
            background-color: #3a4369;
            border-color: #3a4369;
        }
        .card-header {
            background-color: #F9C784;
            color: #333;
        }
        footer {
            background-color: #4E598C;
            color: white;
            padding: 20px 0;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo isset($home_path) ? $home_path : './' ?>index.php">Galerie Oselo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo isset($home_path) ? $home_path : './' ?>index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo isset($home_path) ? $home_path : './' ?>artworks/index.php">Artworks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo isset($home_path) ? $home_path : './' ?>warehouses/index.php">Warehouses</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
