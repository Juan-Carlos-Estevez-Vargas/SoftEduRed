<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rol de Usuario</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
	class RoleUserDAO
	{
		private $pdo;

		/**
		 * Constructor method for the class.
		 *
		 * Establish a database connection using the database class.
		 *
		 * @throws PDOException If there is an error connecting to the database.
		 */
		public function __construct()
		{
				try {
						$this->pdo = database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a user with roles and states
		 *
		 * @param string $docType The user's document type
		 * @param int $userId The user's ID
		 * @throws Exception If the registration fails
		 */
		public function registerUserWithRolesAndStates($docType, $userId)
		{
				try {
						if (!empty($docType) && !empty($userId)) {
								$sql = "SELECT * FROM role";
								$statement = $this->pdo->prepare($sql);
								$statement->execute();
								$roles = $statement->fetchAll(PDO::FETCH_OBJ);
								
								// Iterate over each role and insert into user_has_role table if checked
								foreach ($roles as $role) {
										$descRole = $role->desc_role;
									
										if (isset($_POST[$descRole])) {
												$state = "state_" . $descRole;
												$stateValue = $_REQUEST[$state];
												$sql = "
														INSERT INTO user_has_role (tdoc_role, pk_fk_id_user, pk_fk_role, state)
														VALUES ('$docType', '$userId', '$descRole', '$stateValue')
												";
												$this->pdo->query($sql);
										}
								}

								$this->showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/relationship/roleHasUserView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/roleHasUserView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationship/roleHasUserView.php'
						);
				}
		}

		/**
		 * Updates a record in the user_has_role database table.
		 *
		 * @param string $newTDocRole The new value for the tdoc_role field.
		 * @param string $oldTDocRole The current value of the tdoc_role field.
		 * @param int $newPkFkIdUser The new value for the pk_fk_id_user field.
		 * @param int $oldPkFkIdUser The current value of the pk_fk_id_user field.
		 * @param string $newPkFkRole The new value for the pk_fk_role field.
		 * @param string $oldPkFkRole The current value of the pk_fk_role field.
		 * @param bool $newState The new value for the state field.
		 *
		 * @return void
		 */
		public function updateUserRoles(
			string $newTDocRole, string $oldTDocRole, int $newPkFkIdUser,
			int $oldPkFkIdUser, string $newPkFkRole, string $oldPkFkRole,
			bool $newState
		) {
				try {
						if (!empty($newTDocRole) && !empty($oldTDocRole) && !empty($newPkFkIdUser)
							&& !empty($oldPkFkIdUser) && !empty($newPkFkRole) && !empty($oldPkFkRole))
						{
								$sql = "
										UPDATE user_has_role
										SET tdoc_role = ?,
												pk_fk_id_user = ?,
												pk_fk_role = ?,
												state = ?
										WHERE tdoc_role = ? &&
													pk_fk_id_user = ? &&
													pk_fk_role = ?
								";

								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([
									$newTDocRole, $newPkFkIdUser, $newPkFkRole, $newState,
									$oldTDocRole, $oldPkFkIdUser, $oldPkFkRole
								]);

								$this->showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/relationship/roleHasUserView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/roleHasUserView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationship/roleHasUserView.php'
						);
				}
		}

		/**
		 * Deletes a user's role from the database.
		 *
		 * @param string $documentType The type of document of the user.
		 * @param int $userId The ID of the user.
		 * @param string $role The role to be deleted.
		 * @return void
		 */
		public function deleteUserRole(string $documentType, int $userId, string $role)
		{
				try {
						if (!empty($documentType) && !empty($userId) && !empty($role)) {
								$sql = "
										DELETE FROM user_has_role
										WHERE tdoc_role = '$documentType'
												&& pk_fk_id_user = '$userId'
												&& pk_fk_role = '$role'
								";

								$this->pdo->query($sql);

								$this->showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/relationship/roleHasUserView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/roleHasUserView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationship/roleHasUserView.php'
						);
				}
		}

		/**
		 * Displays a success message using SweetAlert and redirects the user to a specified location.
		 *
		 * @param string $message The success message to display
		 * @param string $redirectURL The URL to redirect to after displaying the message
		 */
		private function showSuccessMessage(string $message, string $redirectURL): void
		{
				echo "
						<script>
								Swal.fire({
										position: 'top-end',
										icon: 'success',
										title: '$message',
										showConfirmButton: false,
										timer: 2000
								}).then(() => {
										window.location = '$redirectURL';
								});
						</script>
				";
		}

		/**
		 * Displays an error message using SweetAlert and redirects the user to a specified location.
		 *
		 * @param string $message The error message to display
		 * @param string $redirectURL The URL to redirect to after displaying the message
		 */
		private function showErrorMessage(string $message, string $redirectURL): void
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
										window.location = '$redirectURL';
								});
						</script>
				";
		}

		/**
		 * Displays an warning message using SweetAlert and redirects the user to a specified location.
		 *
		 * @param string $message The error message to display
		 * @param string $redirectURL The URL to redirect to after displaying the message
		 */
		private function showWarningMessage(string $message, string $redirectURL): void
		{
				echo "
						<script>
								Swal.fire({
										position: 'top-center',
										icon: 'warning',
										title: '$message',
										showConfirmButton: false,
										timer: 2000
								}).then(() => {
										window.location = '$redirectURL';
								});
						</script>
				";
		}
	}
?>
</body>

</html>