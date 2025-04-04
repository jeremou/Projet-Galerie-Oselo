<?php
class Warehouse {
    private $conn;
    private $table_name = "warehouses";

    // Propriétés
    public $id;
    public $name;
    public $address;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lire tous les entrepôts
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    // Lire un entrepôt par ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->name = $row['name'];
            $this->address = $row['address'];
            return true;
        }
        
        return false;
    }

    // Créer un nouvel entrepôt
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name = :name, address = :address";
        
        $stmt = $this->conn->prepare($query);
        
        // Nettoyer et sécuriser les données
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        
        // Liaison des valeurs
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Mettre à jour un entrepôt
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                 SET name = :name, address = :address 
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Nettoyer et sécuriser les données
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->address = htmlspecialchars(strip_tags($this->address));
        
        // Liaison des valeurs
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":address", $this->address);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Supprimer un entrepôt
    public function delete() {
        // D'abord mettre les œuvres à null (warehouse_id)
        $query1 = "UPDATE artworks SET warehouse_id = NULL WHERE warehouse_id = ?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->id);
        $stmt1->execute();
        
        // Ensuite supprimer l'entrepôt
        $query2 = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(1, $this->id);
        
        if($stmt2->execute()) {
            return true;
        }
        
        return false;
    }

    // Compter les œuvres dans un entrepôt
    public function countArtworks() {
        $query = "SELECT COUNT(*) as total FROM artworks WHERE warehouse_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'];
    }
}
?>
