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
    require_once "../persistence/loginDAO.php";
    require_once '../utils/Message.php';
    
    class LoginService
    {

        /**
		 * Initializes a new instance of the class.
		 *
		 * Creates a new PDO connection object using database::conectar().
		 * Throws an exception with the error message if the connection fails.
		 */
		public function __construct()
		{
            try {
                $this->login = new LoginDAO();
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage());
            }
		}
        
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
            $user = $this->login->getUser($db, $username, $password);

            // If user is not found, display error message and redirect to login page
            if (!$user) {
                Message::showErrorMessage(
                    "Usuario y/o contraseña erróneos.",
                    '../../index.php'
                );
                return;
            }

            // Get user role from database
            $role = $this->login->getUserRole($db, $user["id_user"]);

            // Set session variables with user information
            $this->setSessionVariables($user, $role);
             
            // If user does not have a role, display error message and redirect to login page
            if (!$role) {
                Message::showErrorMessage(
                    "El usuario NO se encuentra con un rol asignado.",
                    '../../index.php'
                );
                return;
            }

            // Redirect to appropriate page based on user role
            $this->redirectToRolePage($role["description"]);
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
                case 'DOCENTE':
                    header('location: ../utilities/index.php?role=t');
                    break;
                case 'ADMINISTRADOR':
                    header('location: ../utilities/index.php?role=e');
                    break;
                case 'ACUDIENTE':
                    header('location: ../utilities/index.php?role=a');
                    break;
                default:
                    $this->displayErrorMessage("Rol de usuario no válido.");
                    break;
            }
        }
    }
?>
</body>

</html>