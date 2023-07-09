  <?php
	require_once '../utils/Message.php';

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
		public function register(int $userId, int $roleId, string $state): void
		{
				try {
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
				} catch (Exception $e) {
						// Show error message if registration fails due to internal error.
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleHasUserView.php'
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
		public function update(string $id, string $state): void
		{
				try {
						$sql = "
								UPDATE user_has_role
								SET state = ?
								WHERE id_user_has_role = ?
						";

						$stmt = $this->pdo->prepare($sql);
						$stmt->execute([$state, $id]);
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleHasUserView.php'
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
		public function delete(string $idUserHasRole)
		{
				try {
						$sql = "
								DELETE FROM user_has_role
								WHERE id_user_has_Role = :id
						";

						$statement = $this->pdo->prepare($sql);
						$statement->bindParam(':id', $idUserHasRole);
						$statement->execute();
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleHasUserView.php'
						);
				}
		}

		public function exists($idUser, $roleId): bool {
				try {
						$sql = "
								SELECT COUNT(*) as total
								FROM user_has_role
								WHERE user_id = :user AND role_id = :role
						";
		
						$statement = $this->pdo->prepare($sql);
						$statement->bindParam(':user', $idUser);
						$statement->bindParam(':role', $roleId);
						$statement->execute();
		
						$result = $statement->fetch(PDO::FETCH_ASSOC);
						$total = $result['total'];
		
						return $total > 0;
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/roleHasUserView.php'
						);
				}
		}
  }
?>