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
										INSERT INTO role (desc_role, state)
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
		 * @param string $newDesc The new value for the "desc_role" column.
		 * @param string $oldDesc The value to match in the "desc_role" column of the record to update.
		 * @param string $newState The new value for the "state" column.
		 * @return void
		 */
		public function updateRole(string $newDesc, string $oldDesc, string $newState)
		{
				try {
						if (!empty($newDesc) && !empty($oldDesc)) {
								$sql = "
										UPDATE role
										SET desc_role = UPPER('$newDesc'),
												state = '$newState'
										WHERE desc_role = '$oldDesc'
								";
								$this->pdo->query($sql);
								
								$this->showSuccessMessage(
										"Registro Actualizado Exitosamente.",
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
		 * Deletes a record from the "role" table based on a given description.
		 *
		 * @param string $description The description of the role to be deleted
		 * @throws PDOException If there is an error executing the SQL statement
		 */
		public function deleteRole(string $description)
		{
				try {
						if (!empty($description)) {
								$sql = "DELETE FROM role WHERE desc_role = :description";
								$stmt = $this->pdo->prepare($sql);
								$stmt->bindParam(':description', $description);
								$stmt->execute();
								
								$this->showSuccessMessage(
										"Registro Eliminado Exitosamente.",
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