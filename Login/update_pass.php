<?php
    class RecoveryPassword
    {
        /**
         * Recovers user password, updates it in the database and destroys the session.
         *
         * @param string $newPassword - The new password entered by the user.
         * @param string $passwordConfirmation - The confirmation of the new password entered by the user.
         */
        public function recuperar($newPassword, $passwordConfirmation)
        {
            session_start();
            require_once "../Database/conexion.php";
            $database = database::conectar();

            $userId = $this->getUserIdFromSession($database);

            if ($newPassword === $passwordConfirmation) {
                $this->updatePasswordInDatabase($database, $newPassword);
                session_destroy();
                header("location: ../index.php");
            } else {
                header("location: formulario_new_contrasena.php");
            }
        }

        /**
         * Retrieve user id from session data.
         *
         * @param PDO $database
         * @return int
         */
        private function getUserIdFromSession(PDO $database): int
        {
            $sql = "SELECT id FROM user
                    WHERE id_user = :id_user
                    AND pk_fk_cod_doc = :tdoc";
            $statement = $database->prepare($sql);
            $statement->execute([
                ':id_user' => $_SESSION['id'],
                ':tdoc' => $_SESSION['tdoc']
            ]);
            $result = $statement->fetch();

            return intval($result['id']);
        }

        /**
         * Update user's password in the database.
         *
         * @param PDO $db
         * @param string $password
         */
        private function updatePassword(PDO $db, string $password): void
        {
            $sql = "UPDATE user SET pass = :password WHERE pk_fk_cod_doc = :tdoc AND id_user = :id";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':password' => $password,
                ':tdoc' => $_SESSION['tdoc'],
                ':id' => $_SESSION['id']
            ]);
        }
    }
    $Nuevo = new Recu_pass();
    $Nuevo->recuperar($_POST['pass'], $_POST['pass_conf']);
?>  