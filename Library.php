<?php
class Library {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getBooks($search = "", $genre = "") {
        $sql = "SELECT * FROM book WHERE 1=1";
        $params = [];

       
        if (!empty($search)) {
            $sql .= " AND (title LIKE ? OR author LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

       
        if (!empty($genre)) {
            $sql .= " AND genre = ?";
            $params[] = $genre;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
