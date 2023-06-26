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
		 * Registers a user with the specified roles and states.
		 *
		 * @param int $userId The ID of the user being registered.
		 * @param int $roleId The ID of the role being assigned to the user.
		 * @param string $state The state of the registration.
		 * @throws Exception If the registration fails.
		 */
		public function registerUser(int $userId, int $roleId, string $state): void
		{
				try {
						if (empty($userId) || empty($roleId)) {
								// Show warning message if user ID or role ID are empty.
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/roleHasUserView.php'
								);
								return;
						}

						$sql = "INSERT INTO user_has_role (user_id, role_id, state) VALUES (:user, :role, :state)";
						$statement = $this->pdo->prepare($sql);
						$statement->bindParam(':user', $userId);
						$statement->bindParam(':role', $roleId);
						$statement->bindParam(':state', $state);
						$statement->execute();

						// Show success message upon successful registration.
						$this->showSuccessMessage(
								"Registro Agregado Exitosamente.",
								'../../views/relationship/roleHasUserView.php'
						);
				} catch (Exception $e) {
						// Show error message if registration fails due to internal error.
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
		public function deleteUserRole(string $idUserHasRole)
		{
				try {
						if (!empty($idUserHasRole)) {
								$sql = "
										DELETE FROM user_has_role
										WHERE id_user_has_Role = :id
								";

								$statement = $this->pdo->prepare($sql);
								$statement->bindParam(':id', $idUserHasRole);
								$statement->execute();

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