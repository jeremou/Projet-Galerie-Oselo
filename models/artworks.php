<?php
class Artwork {
    // DB connection and table
    private $conn;
    private $table_name = "artworks";
 
    // Object properties
    public $id;
    public $title;
    public $artist;
    public $year;
    public $height;
    public $width;
    public $depth;
    public $warehouse_id;
    public $warehouse_name;
    public $description;
    public $image_url;
    public $created_at;
    public $updated_at;
 
    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }
 
    // Read all artworks with warehouse name
    public function readAll() {
        $query = "SELECT a.*, w.name as warehouse_name 
                  FROM " . $this->table_name . " a 
                  LEFT JOIN warehouses w ON a.warehouse_id = w.id 
                  ORDER BY a.title";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
 
        return $stmt;
    }
    
    // Read the latest artworks
    public function readLatest($limit = 5) {
        $query = "SELECT a.*, w.name as warehouse_name 
                  FROM " . $this->table_name . " a 
                  LEFT JOIN warehouses w ON a.warehouse_id = w.id 
                  ORDER BY a.created_at DESC 
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
 
    // Read one artwork
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
            $this->artist = $row['artist'];
            $this->year = $row['year'];
            $this->height = $row['height'];
            $this->width = $row['width'];
            $this->depth = $row['depth'];
            $this->warehouse_id = $row['warehouse_id'];
            $this->warehouse_name = $row['warehouse_name'];
            $this->description = $row['description'];
            $this->image_url = $row['image_url'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
 
        return false;
    }
 
    // Create artwork
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET title=:title, artist=:artist, year=:year, height=:height, 
                      width=:width, depth=:depth, warehouse_id=:warehouse_id, 
                      description=:description, image_url=:image_url";
        $stmt = $this->conn->prepare($query);
 
        // Sanitize inputs
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->artist = htmlspecialchars(strip_tags($this->artist));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->height = htmlspecialchars(strip_tags($this->height));
        $this->width = htmlspecialchars(strip_tags($this->width));
        $this->depth = htmlspecialchars(strip_tags($this->depth));
        $this->warehouse_id = htmlspecialchars(strip_tags($this->warehouse_id));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
 
        // Bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":artist", $this->artist);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":height", $this->height);
        $stmt->bindParam(":width", $this->width);
        $stmt->bindParam(":depth", $this->depth);
        $stmt->bindParam(":warehouse_id", $this->warehouse_id);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image_url", $this->image_url);
 
        // Execute query
        if($stmt->execute()) {
            return true;
        }
 
        return false;
    }
 
    // Update artwork
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET title=:title, artist=:artist, year=:year, height=:height, 
                      width=:width, depth=:depth, warehouse_id=:warehouse_id, 
                      description=:description, image_url=:image_url
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
 
        // Sanitize inputs
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->artist = htmlspecialchars(strip_tags($this->artist));
        $this->year = htmlspecialchars(strip_tags($this->year));
        $this->height = htmlspecialchars(strip_tags($this->height));
        $this->width = htmlspecialchars(strip_tags($this->width));
        $this->depth = htmlspecialchars(strip_tags($this->depth));
        $this->warehouse_id = htmlspecialchars(strip_tags($this->warehouse_id));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
 
        // Bind values
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":artist", $this->artist);
        $stmt->bindParam(":year", $this->year);
        $stmt->bindParam(":height", $this->height);
        $stmt->bindParam(":width", $this->width);
        $stmt->bindParam(":depth", $this->depth);
        $stmt->bindParam(":warehouse_id", $this->warehouse_id);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":image_url", $this->image_url);
 
        // Execute query
        if($stmt->execute()) {
            return true;
        }
 
        return false;
    }
 
    // Delete artwork
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
 
        // Sanitize input
        $this->id = htmlspecialchars(strip_tags($this->id));
 
        // Bind id of record to delete
        $stmt->bindParam(1, $this->id);
 
        // Execute query
        if($stmt->execute()) {
            return true;
        }
 
        return false;
    }
}
?>
