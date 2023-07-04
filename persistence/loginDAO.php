<?php
    require_once '../utils/Message.php';
    
    class LoginDAO
    {
        /**
         * Retrieves a user from the database based on the username and password
         *
         * @param PDO $db The database connection
         * @param string $username The username of the user
         * @param string $password The password of the user
         *
         * @return array|false Returns the user as an associative array if found, false otherwise
         */
        public function getUser(PDO $db, string $username, string $password)
        {
            try {
                $sql = "
                    SELECT * FROM user
                    WHERE username = :username
                        AND password = :password
                ";
                $stmt = $db->prepare($sql);
                $stmt->execute(['username' => $username, 'password' => $password]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                Message::showErrorMessage(
                    "Ocurrió un error interno. Consulta al Administrador.",
                    '../../index.php'
                );
            }
        }

        /**
         * Retrieves the role of a user from the database
         *
         * @param PDO $db The database connection
         * @param int $userId The ID of the user
         *
         * @return array|false Returns the role as an associative array if found, false otherwise
         */
        public function getUserRole(PDO $db, int $userId)
        {
            try {
                $sql = "
                    SELECT description FROM role
                    JOIN user_has_role
                        ON id_role = role_id
                    WHERE user_id = :user_id
                ";
                $stmt = $db->prepare($sql);
                $stmt->execute(['user_id' => $userId]);
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                Message::showErrorMessage(
                    "Ocurrió un error interno. Consulta al Administrador.",
                    '../../index.php'
                );
            }
        }
    }
?>