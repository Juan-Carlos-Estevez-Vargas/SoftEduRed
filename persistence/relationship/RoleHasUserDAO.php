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
	require_once '../../utils/Message.php';

	class RoleHasUserDAO
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
		public function registerUserRole(int $userId, int $roleId, string $state): void
		{
				try {
						if (empty($userId) || empty($roleId) || ($state !== '1' && $state !== '0')) {
								// Show warning message if user ID or role ID are empty.
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/roleHasUserView.php'
								);
								return;
						}

						$sql = "
								INSERT INTO user_has_role (
										user_id,
										role_id,
										state)
								VALUES (:user, :role, :state);
						";
						$statement = $this->pdo->prepare($sql);
						$statement->bindParam(':user', $userId);
						$statement->bindParam(':role', $roleId);
						$statement->bindParam(':state', $state);
						$statement->execute();

						// Show success message upon successful registration.
						Message::showSuccessMessage(
								"Registro Agregado Exitosamente.",
								'../../views/relationship/roleHasUserView.php'
						);
				} catch (Exception $e) {
						// Show error message if registration fails due to internal error.
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationship/roleHasUserView.php'
						);
				}
		}

		/**
		 * Updates a record in the user_has_role database table.
		 *
		 * @param string $id The id_user_has_role to update.
		 * @param string $state The new value for the state field.
		 *
		 * @return void
		 */
		public function updateUserRoles(string $id, string $state): void
		{
				try {
						if (!empty($id))
						{
								$sql = "
										UPDATE user_has_role
										SET state = ?
										WHERE id_user_has_role = ?
								";

								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([$state, $id]);

								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/relationship/roleHasUserView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/roleHasUserView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
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

								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/relationship/roleHasUserView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/roleHasUserView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationship/roleHasUserView.php'
						);
				}
		}
	}
?>
</body>

</html>