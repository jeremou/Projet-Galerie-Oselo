<?php
class Artwork {
    private $conn;
    private $table_name = "artworks";

    // Propriétés
    public $id;
    public $title;
    public $year_of_production;
    public $artist_name;
    public $width;
    public $height;
    public $warehouse_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lire toutes les œuvres
    public function readAll() {
        $query = "SELECT a.*, w.name as warehouse_name 
                 FROM " . $this->table_name . " a 
                 LEFT JOIN warehouses w ON a.warehouse_id = w.id 
                 ORDER BY a.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    // Lire une œuvre par son ID
    public function readOne() {
        $query = "SELECT a.*, w.name as warehouse_name 
                 FROM " . $this->table_name . " a 
                 LEFT JOIN warehouses w ON a.warehouse_id = w.id 
                 WHERE a.id = ? 
                 LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->title = $row['title'];
            $this->year_of_production = $row['year_of_production'];
            $this->artist_name = $row['artist_name'];
            $this->width = $row['width'];
            $this->height = $row['height'];
            $this->warehouse_id = $row['warehouse_id'];
            return true;
        }
        
        return false;
    }

    // Créer une nouvelle œuvre
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                 SET title = :title, 
                     year_of_production = :year, 
                     artist_name = :artist, 
                     width = :width, 
                     height = :height, 
                     warehouse_id = :warehouse";
        
        $stmt = $this->conn->prepare($query);
        
        // Nettoyer et sécuriser les données
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->year_of_production = htmlspecialchars(strip_tags($this->year_of_production));
        $this->artist_name = htmlspecialchars(strip_tags($this->artist_name));
        $this->width = htmlspecialchars(strip_tags($this->width));
        $this->height = htmlspecialchars(strip_tags($this->height));
        
        // Liaison des valeurs
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":year", $this->year_of_production);
        $stmt->bindParam(":artist", $this->artist_name);
        $stmt->bindParam(":width", $this->width);
        $stmt->bindParam(":height", $this->height);
        $stmt->bindParam(":warehouse", $this->warehouse_id);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Mettre à jour une œuvre
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                 SET title = :title, 
                     year_of_production = :year, 
                     artist_name = :artist, 
                     width = :width, 
                     height = :height, 
                     warehouse_id = :warehouse 
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Nettoyer et sécuriser les données
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->year_of_production = htmlspecialchars(strip_tags($this->year_of_production));
        $this->artist_name = htmlspecialchars(strip_tags($this->artist_name));
        $this->width = htmlspecialchars(strip_tags($this->width));
        $this->height = htmlspecialchars(strip_tags($this->height));
        
        // Liaison des valeurs
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":year", $this->year_of_production);
        $stmt->bindParam(":artist", $this->artist_name);
        $stmt->bindParam(":width", $this->width);
        $stmt->bindParam(":height", $this->height);
        $stmt->bindParam(":warehouse", $this->warehouse_id);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Supprimer une œuvre
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Lire les œuvres par entrepôt
    public function readByWarehouse($warehouse_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                 WHERE warehouse_id = ? 
                 ORDER BY id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $warehouse_id);
        $stmt->execute();
        
        return $stmt;
    }

    // Assigner à un entrepôt
    public function assignToWarehouse() {
        $query = "UPDATE " . $this->table_name . " 
                 SET warehouse_id = :warehouse_id 
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":warehouse_id", $this->warehouse_id);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>
