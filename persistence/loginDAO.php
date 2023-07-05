<?php
require_once '../utils/Message.php';
require_once '../persistence/database/Database.php';

class LoginDAO
{
    private $pdo;

    /**
     * Constructor for the class.
     *
     * @throws PDOException if there is an error connecting to the database.
     */
    public function __construct()
    {
        try {
            $this->pdo = Database::connect();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
    }

    /**
     * Retrieves a user from the database based on the username and password
     *
     * @param string $username The username of the user
     * @param string $password The password of the user
     *
     * @return array|false Returns the user as an associative array if found, false otherwise
     */
    public function getUser(string $username, string $password)
    {
        try {
            $sql = "SELECT * FROM user WHERE username = :username AND password = :password";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['username' => $username, 'password' => $password]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Message::showErrorMessage("Ocurrió un error interno. Consulta al Administrador.", '../../index.php');
            return false;
        }
    }

    /**
     * Retrieves the role of a user from the database
     *
     * @param int $userId The ID of the user
     *
     * @return array|false Returns the role as an associative array if found, false otherwise
     */
    public function getUserRole(int $userId)
    {
        try {
            $sql = "SELECT description FROM role JOIN user_has_role ON id_role = role_id WHERE user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Message::showErrorMessage("Ocurrió un error interno. Consulta al Administrador.", '../../index.php');
            return false;
        }
    }
}
?>