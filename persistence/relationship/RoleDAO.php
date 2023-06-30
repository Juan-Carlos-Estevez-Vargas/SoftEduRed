<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rol</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
	require_once '../../utils/Message.php';

	class RoleDAO
	{
		private $pdo;

		/**
		 * Initializes a new instance of the class.
		 *
		 * Creates a new PDO connection object using database::conectar().
		 * Throws an exception with the error message if the connection fails.
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
		 * Adds a new role to the database with the provided description and state
		 *
		 * @param string $description The description of the role
		 * @param string $state The state of the role
		 * @return void
		 */
		public function addRole(string $description, string $state): void
		{
				try {
						if (!empty($description)) {
								$sql = "
										INSERT INTO role (description, state)
										VALUES (UPPER(:description), :state)
								";
								$statement = $this->pdo->prepare($sql);
								$statement->execute(['description' => $description, 'state' => $state]);
								
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/relationship/roleView.php'
								);
					} else {
							Message::showWarningMessage(
									"Debes llenar todos los campos.",
									'../../views/relationship/roleView.php'
							);
					}
			} catch (Exception $e) {
					Message::showErrorMessage(
							"Ocurrió un error interno. Consulta al Administrador.",
							'../../views/relationship/roleView.php'
					);
			}
		}

		/**
		 * Updates a record in the "role" table.
		 *
		 * @param string $idRole  The ID of the role to update.
		 * @param string $role    The new value for the "description" column.
		 * @param string $state   The new value for the "state" column.
		 *
		 * @return void
		 */
		public function updateRole(string $idRole, string $role, string $state)
		{
				try {
						// Only update if both $idRole and $role are not empty.
						if (!empty($role) && !empty($idRole)) {
								$sql = "
										UPDATE role
										SET description = UPPER(:role),
												state = :state
										WHERE id_role = :idRole
								";
								// Prepare the SQL statement.
								$stmt = $this->pdo->prepare($sql);
								// Bind the parameters.
								$stmt->bindParam(':role', $role);
								$stmt->bindParam(':state', $state);
								$stmt->bindParam(':idRole', $idRole);
								// Execute the statement.
								$stmt->execute();
								// Show success message.
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/relationship/roleView.php'
								);
						} else {
								// Show warning message if $idRole or $role is empty.
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/roleView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if an exception occurs.
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationship/roleView.php'
						);
				}
		}

		/**
		 * Deletes a record from the "role" table based on a given ID.
		 *
		 * @param string $idRole The ID of the role to be deleted
		 * @throws PDOException If there is an error executing the SQL statement
		 */
		public function deleteRole(string $idRole)
		{
				try {
						// Check if ID is not empty
						if (!empty($idRole)) {
								$sql = "
										UPDATE role
										SET state = 3
										WHERE id_role = :role
								";
								$stmt = $this->pdo->prepare($sql);
								$stmt->bindParam(':role', $idRole);
								$stmt->execute();
								
								// Show success message
								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/relationship/roleView.php'
								);
						} else {
								// Show warning message if ID is empty
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/roleView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if there is an exception
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationship/roleView.php'
						);
				}
		}
	}
?>
</body>

</html>