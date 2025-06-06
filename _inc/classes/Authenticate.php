<?php
class Authenticate
{
    private $db;

    public function __construct(Database $database)
    {
        $this->db = $database->getConnection();
    }

    public function login($email, $password) {
        $user = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $user->bindParam(':email', $email, PDO::PARAM_STR);
        $user->execute();
        $user = $user->fetch();
    
        if ($user) {
            if (password_verify($password, $user['password'])) {
                echo "Password verified.<br>";
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['name'] = $user['name'];
                return true;
            } else {
                echo "Password verification failed.<br>";
            }
        } else {
            echo "User not found.<br>";
        }
        return false;
    }

    public function logout() {
        // Zrušenie všetkých session premenných
        $_SESSION = array();
    
        // Skontroluj či PHP používa cookies na správu session ID
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            // Nastav session cookie s prázdnou hodnotou a expiráciou v minulosti,
            // čím sa efektívne odstráni z prehliadača
            setcookie(
                session_name(), // Názov session cookie (napr. PHPSESSID)
                '',             // Prázdna hodnota cookie (bude vymazaná)
                time() - 42000, // Expirácia v minulosti (42 000 sekúnd späť)
                $params["path"],      // Rovnaká cesta ako pôvodná cookie
                $params["domain"],    // Rovnaká doména ako pôvodná cookie
                $params["secure"],    // Nastavenie zabezpečenia HTTPS (ak bolo nastavené)
                $params["httponly"]   // Nastavenie HTTPONLY (ochrana proti XSS)
            );
        }
    
        session_destroy();
    }
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    public function getUserRole() {
        return $_SESSION['role'] ?? null;
    }
    public function requireLogin() {
        if(!$this->isLoggedIn()) {
            header("Location: login.php");
            exit;
        }
    }
}
?>