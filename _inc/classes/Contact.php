<?php
class Contact {
    private $db;

    public function __construct(Database $database) {
        $this->db = $database; // Store Database object
    }

    public function index() {
        $stmt = $this->db->getConnection()->prepare("SELECT id, name, email, message FROM contact ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPublicMessages() {
        $stmt = $this->db->getConnection()->prepare("SELECT name, message FROM contact ORDER BY id DESC LIMIT 50");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function destroy($id) {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM contact WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function create($name, $email, $message) {
        $stmt = $this->db->getConnection()->prepare("INSERT INTO contact (name, email, message) VALUES (:name, :email, :message)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update($id, $message) {
        $stmt = $this->db->getConnection()->prepare("UPDATE contact SET message = :message WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function show($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT id, name, email, message FROM contact WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function edit($id, $name, $email, $message) {
        $stmt = $this->db->getConnection()->prepare("UPDATE contact SET name = :name, email = :email, message = :message WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getUserMessages($email) {
        $stmt = $this->db->getConnection()->prepare("SELECT id, name, email, message FROM contact WHERE email = :email ORDER BY id DESC");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>