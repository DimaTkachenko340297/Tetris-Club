<?php

    class Contact{
        private $db;

        public function __construct(Database $database){
            $this->db = $database->getConnection();
        }

        public function index(){
            $stmt = $this->db->prepare("SELECT * FROM contact");
            $stmt->execute();
            //FETCH_ASSOC - ziskame asociativne pole
            //FETCH_OBJ - ziskame data ako objekt
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        public function destroy($id) {
            $stmt = $this->db->prepare("DELETE FROM contact WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); //PDO::PARAM_INT - nepovinne
            return $stmt->execute();
        }
        
        public function create($name, $email, $message){
            $stmt = $this->db->prepare("INSERT INTO contact (name, email, message) VALUES (:name, :email, :message)");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            return $stmt->execute();

        }
        public function show($id){
            $stmt = $this->db->prepare("SELECT * FROM contact WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function edit($id, $name, $email, $message) {
            $stmt = $this->db->prepare("UPDATE contact SET name = :name, email = :email, 
            message = :message WHERE id = :id");
            
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            return $stmt->execute();
        }
    
    }
?>