<?php
class Oeuvre {
    private $conn;
    private $table_name = "oeuvres";

    // Propriétés
    public $id;
    public $titre;
    public $annee_production;
    public $nom_artiste;
    public $largeur;
    public $hauteur;
    public $entrepot_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lire toutes les œuvres
    public function lireTout() {
        $query = "SELECT o.id, o.titre, o.annee_production, o.nom_artiste, o.largeur, o.hauteur, 
                  o.entrepot_id, e.nom as nom_entrepot 
                  FROM " . $this->table_name . " o 
                  LEFT JOIN entrepots e ON o.entrepot_id = e.id 
                  ORDER BY o.id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    // Lire une seule œuvre
    public function lireUn() {
        $query = "SELECT o.id, o.titre, o.annee_production, o.nom_artiste, o.largeur, o.hauteur, 
                  o.entrepot_id, e.nom as nom_entrepot 
                  FROM " . $this->table_name . " o 
                  LEFT JOIN entrepots e ON o.entrepot_id = e.id 
                  WHERE o.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->titre = $row['titre'];
            $this->annee_production = $row['annee_production'];
            $this->nom_artiste = $row['nom_artiste'];
            $this->largeur = $row['largeur'];
            $this->hauteur = $row['hauteur'];
            $this->entrepot_id = $row['entrepot_id'];
            
            return true;
        }
        
        return false;
    }
    
    // Créer une œuvre
    public function creer() {
        $query = "INSERT INTO " . $this->table_name . "
                  (titre, annee_production, nom_artiste, largeur, hauteur, entrepot_id) 
                  VALUES 
                  (:titre, :annee_production, :nom_artiste, :largeur, :hauteur, :entrepot_id)";
        
        $stmt = $this->conn->prepare($query);
        
        // Nettoyage
        $this->titre = htmlspecialchars(strip_tags($this->titre));
        $this->annee_production = htmlspecialchars(strip_tags($this->annee_production));
        $this->nom_artiste = htmlspecialchars(strip_tags($this->nom_artiste));
        $this->largeur = htmlspecialchars(strip_tags($this->largeur));
        $this->hauteur = htmlspecialchars(strip_tags($this->hauteur));
        
        // Liaison des paramètres
        $stmt->bindParam(":titre", $this->titre);
        $stmt->bindParam(":annee_production", $this->annee_production);
        $stmt->bindParam(":nom_artiste", $this->nom_artiste);
        $stmt->bindParam(":largeur", $this->largeur);
        $stmt->bindParam(":hauteur", $this->hauteur);
        $stmt->bindParam(":entrepot_id", $this->entrepot_id);
        
        // Exécution
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Mettre à jour une œuvre
    public function modifier() {
        $query = "UPDATE " . $this->table_name . "
                  SET titre = :titre, 
                      annee_production = :annee_production, 
                      nom_artiste = :nom_artiste, 
                      largeur = :largeur, 
                      hauteur = :hauteur, 
                      entrepot_id = :entrepot_id
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        // Nettoyage
        $this->titre = htmlspecialchars(strip_tags($this->titre));
        $this->annee_production = htmlspecialchars(strip_tags($this->annee_production));
        $this->nom_artiste = htmlspecialchars(strip_tags($this->nom_artiste));
        $this->largeur = htmlspecialchars(strip_tags($this->largeur));
        $this->hauteur = htmlspecialchars(strip_tags($this->hauteur));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Liaison des paramètres
        $stmt->bindParam(":titre", $this->titre);
        $stmt->bindParam(":annee_production", $this->annee_production);
        $stmt->bindParam(":nom_artiste", $this->nom_artiste);
        $stmt->bindParam(":largeur", $this->largeur);
        $stmt->bindParam(":hauteur", $this->hauteur);
        $stmt->bindParam(":entrepot_id", $this->entrepot_id);
        $stmt->bindParam(":id", $this->id);
        
        // Exécution
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Supprimer une œuvre
    public function supprimer() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }

    // Lire les œuvres par entrepôt
    public function lireParEntrepot($entrepot_id) {
        $query = "SELECT o.id, o.titre, o.annee_production, o.nom_artiste, o.largeur, o.hauteur 
                  FROM " . $this->table_name . " o 
                  WHERE o.entrepot_id = :entrepot_id
                  ORDER BY o.titre ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":entrepot_id", $entrepot_id);
        $stmt->execute();
        
        return $stmt;
    }
}
?>
