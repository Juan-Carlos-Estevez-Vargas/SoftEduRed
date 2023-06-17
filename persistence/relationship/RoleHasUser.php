<?php
	class RoleUser
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
				// Fetch all roles from the database
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
						
				print "
					<script>
						alert('Registro Agregado Exitosamente.');
						window.location='../views/relationship/roleHasUserView.php';
					</script>
				";
					
			} catch (Exception $e) {
				print "
					<script>
						alert('Registro FALLIDO.');
						window.location='../views/relationship/roleHasUserView.php';
					</script>
				";
				throw $e;
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
			
			$message = "Registro Actualizado Exitosamente.";
			echo "
				<script>
					alert('$message');
					window.location='../views/relationship/roleHasUserView.php';
				</script>
			";
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
			$sql = "DELETE FROM user_has_role
							WHERE tdoc_role = '$documentType'
							&& pk_fk_id_user = '$userId'
							&& pk_fk_role = '$role'";

			$this->pdo->query($sql);

			print "
				<script>
					alert('Registro Eliminado Exitosamente.');
					window.location='../views/relationship/roleHasUserView.php';
				</script>
			";
		}
	}
?>
