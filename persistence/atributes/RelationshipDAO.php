<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Parentesco</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
	class RelationshipDAO
	{
		private $pdo;

		/**
		 * Initializes a new instance of the class by setting up a PDO connection to the database
		 *
		 * @throws PDOException if there is an error connecting to the database
		 */
		public function __construct()
		{
				try {
						$this->pdo = Database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a new relationship with the given description and state.
		 *
		 * @param string $description The description of the relationship to be registered.
		 * @param string $state The state of the relationship to be registered.
		 * @return void
		 */
		public function registerRelationship(string $description, string $state): void
		{
				try {
						if (!empty($description)) {
								$query = "
										INSERT INTO relationship (desc_relationship, state)
										VALUES (UPPER(:description), :state)
								";
			
								$statement = $this->pdo->prepare($query);
								$statement->bindParam(':description', $description);
								$statement->bindParam(':state', $state);
								$statement->execute();
			
								$this->showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/atributes/relationshipView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/relationshipView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/relationshipView.php'
						);
				}
		}

		/**
		 * Update a record in the 'relationship' table.
		 *
		 * @param string $newRelationship The new value for 'desc_relationship'.
		 * @param string $queryRelationship The value to match in 'desc_relationship'.
		 * @param string $newState The new value for 'state'.
		 *
		 * @return void
		 */
		public function updateRecord(string $newRelationship, string $queryRelationship, string $newState)
		{
				try {
						if (!empty($newRelationship) && !empty($queryRelationship)) {
								$sql = "
										UPDATE relationship
										SET desc_relationship = UPPER(:newRelationship),
												state = :newState
										WHERE desc_relationship = :queryRelationship
								";
								
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([
										'newRelationship' => $newRelationship,
										'newState' => $newState,
										'queryRelationship' => $queryRelationship
								]);
			
								$this->showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/atributes/relationshipView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/relationshipView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/relationshipView.php'
						);
				}
		}

		/**
		 * Deletes a record from the relationship table based on the description of the relationship.
		 *
		 * @param string $relation The description of the relationship to delete.
		 * @return void
		 */
		public function deleteRelationship(string $relation): void
		{
				try {
						if (!empty($relation)) {
								$sql = "DELETE FROM relationship WHERE desc_relationship = :relation";
								$stmt = $this->pdo->prepare($sql);
								$stmt->bindParam(':relation', $relation, PDO::PARAM_STR);
								$stmt->execute();
								
								$this->showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/atributes/relationshipView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/relationshipView.php'
								);
						}
				} catch (Exception $e) {
				$this->showErrorMessage(
						"Ocurrió un error interno. Consulta al Administrador.",
						'../../views/atributes/relationshipView.php'
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