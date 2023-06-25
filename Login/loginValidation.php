<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
    class Login
    {
        /**
         * Logs in a user
         *
         * @param string $username The username of the user
         * @param string $password The password of the user
         *
         * @return void
         */
        public function loginUser(string $username, string $password): void
        {
            // Start session
            session_start();

            // Connect to database
            require_once "../persistence/database/Database.php";
            $db = Database::connect();

            // Get user from database
            $user = $this->getUser($db, $username, $password);

            // If user is not found, display error message and redirect to login page
            if (!$user) {
                $this->displayErrorMessage("Usuario y/o Contraseña Incorrectos.");
                return;
            }

            // Get user role from database
            $role = $this->getUserRole($db, $user["id_user"]);

            // Set session variables with user information
            $this->setSessionVariables($user, $role);
             
            // If user does not have a role, display error message and redirect to login page
            if (!$role) {
                $this->displayErrorMessage("El usuario NO se encuentra con un rol asignado.");
                return;
            }

            // Redirect to appropriate page based on user role
            $this->redirectToRolePage($role["description"]);
        }

        /**
         * Retrieves a user from the database based on the username and password
         *
         * @param PDO $db The database connection
         * @param string $username The username of the user
         * @param string $password The password of the user
         *
         * @return array|false Returns the user as an associative array if found, false otherwise
         */
        private function getUser(PDO $db, string $username, string $password)
        {
            $sql = "
                SELECT * FROM user
                WHERE username = :username
                    AND password = :password
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute(['username' => $username, 'password' => $password]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Sets session variables with user information
         *
         * @param array $user The user information
         *
         * @return void
         */
        private function setSessionVariables(array $user, array $role): void
        {
            $_SESSION["ID_USER"] = $user["id_user"];
            $_SESSION["USERNAME"] = $user["username"];
            $_SESSION["PHOTO"] = $user["photo"];
            $_SESSION["NAME"] = $user["first_name"];
            $_SESSION["SNAME"] = $user["second_name"];
            $_SESSION["LASTNAME"] = $user["surname"];
            $_SESSION["SLASTNAME"] = $user["second_surname"];
            $_SESSION["ROLE"] = $role["description"];
        }

        /**
         * Retrieves the role of a user from the database
         *
         * @param PDO $db The database connection
         * @param int $userId The ID of the user
         *
         * @return array|false Returns the role as an associative array if found, false otherwise
         */
        private function getUserRole(PDO $db, int $userId)
        {
            $sql = "
                SELECT description FROM role
                JOIN user_has_role
                    ON id_role = role_id
                WHERE user_id = :user_id
            ";
            $stmt = $db->prepare($sql);
            $stmt->execute(['user_id' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Redirects the user to the appropriate page based on their role
         *
         * @param string $roleId The role ID of the user
         *
         * @return void
         */
        private function redirectToRolePage(string $role): void
        {
            $_SESSION['active'] = 1;
            switch ($role) {
                case 'TEACHER':
                    header('location: ../utilities/index.php?role=t');
                    break;
                case 'ADMINISTRADOR':
                    header('location: ../utilities/index.php?role=e');
                    break;
                case 'ATTENDANT':
                    header('location: ../utilities/index.php?role=a');
                    break;
                default:
                    $this->displayErrorMessage("Rol de usuario no válido.");
                    break;
            }
        }

        /**
         * Displays an error message using SweetAlert and redirects the user to a specified location
         *
         * @param string $message The error message to display
         * @param string $location The location to redirect the user after displaying the error message
         *
         * @return void
         */
        private function displayErrorMessage(string $message, string $location = '../index.php'): void
        {
            echo "
                <script>
                    Swal.fire({
                            position: 'top-center',
                            icon: 'error',
                            title: '$message',
                            showConfirmButton: false,
                            timer: 2000
                    }).then(() => {
                            window.location = '$location';
                    });
                </script>
            ";
        }

    }
    
    $new = new Login();
    $new->loginUser($_POST["username"], $_POST["password"]);
?>
</body>

</html>