<?php
require_once '_inc/classes/Database.php';

class User {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function index() {
        $query = "SELECT id, name, email, role, points FROM users WHERE role = 1 ORDER BY points DESC";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $query = "SELECT id, name, email, role, points FROM users WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePoints($id, $points) {
        $query = "UPDATE users SET points = points + ? WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        return $stmt->execute([$points, $id]);
    }

    public function show($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $email, $role, $password) {
        $stmt = $this->db->getConnection()->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO users (name, email, role, password) 
            VALUES (:name, :email, :role, :password)
        ");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function edit($id, $name, $email, $role, $points) {
        $stmt = $this->db->getConnection()->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            return false;
        }

        $stmt = $this->db->getConnection()->prepare("
            UPDATE users 
            SET name = :name, email = :email, role = :role, points = :points
            WHERE id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':points', $points, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function destroy($id) {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>