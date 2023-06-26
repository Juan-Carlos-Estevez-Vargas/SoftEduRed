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
								
								$this->showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/relationship/roleView.php'
								);
					} else {
							$this->showWarningMessage(
									"Debes llenar todos los campos.",
									'../../views/relationship/roleView.php'
							);
					}
			} catch (Exception $e) {
					$this->showErrorMessage(
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
								$this->showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/relationship/roleView.php'
								);
						} else {
								// Show warning message if $idRole or $role is empty.
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/roleView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if an exception occurs.
						$this->showErrorMessage(
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
								$sql = "DELETE FROM role WHERE id_role = :role";
								$stmt = $this->pdo->prepare($sql);
								$stmt->bindParam(':role', $idRole);
								$stmt->execute();
								
								// Show success message
								$this->showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/relationship/roleView.php'
								);
						} else {
								// Show warning message if ID is empty
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/roleView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if there is an exception
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationship/roleView.php'
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