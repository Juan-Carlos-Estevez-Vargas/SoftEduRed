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
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
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
            // Verificar el captcha
            $captchaResponse = $_POST['g-recaptcha-response'];
            $secretKey = '6LfljvYmAAAAAApKPbs6XoVZtiPxL0lxl9PnQuGa';
            if (!$this->validateCaptcha($captchaResponse, $secretKey)) {
                Message::showErrorMessage(
                    "Captcha inválido.",
                    '../../index.php'
                );
                return;
            }
    
            // Start session
            session_start();

            // Get user from database
            $user = $this->login->getUser($username, $password);

            // If user is not found, display error message and redirect to login page
            if (!$user) {
                Message::showErrorMessage(
                    "Usuario y/o contraseña erróneos.",
                    '../../index.php'
                );
                return;
            }

            // Get user role from database
            $role = $this->login->getUserRole($user["id_user"]);

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
                    header('location: ../utils/index.php?role=t');
                    break;
                case 'ADMINISTRADOR':
                    header('location: ../utils/index.php?role=e');
                    break;
                case 'ACUDIENTE':
                    header('location: ../utils/index.php?role=a');
                    break;
                default:
                    $this->displayErrorMessage("Rol de usuario no válido.");
                    break;
            }
        }

        /**
         * Valida el captcha de reCAPTCHA
         *
         * @param string $response El valor de respuesta recibido del formulario
         * @param string $secretKey La clave secreta (secret key) de reCAPTCHA
         *
         * @return bool Devuelve true si el captcha es válido, false de lo contrario
         */
        private function validateCaptcha(string $response, string $secretKey): bool
        {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array(
                'secret' => $secretKey,
                'response' => $response
            );

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data)
                )
            );

            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $responseJson = json_decode($result);

            return isset($responseJson->success) && $responseJson->success === true;
        }

    }
?>