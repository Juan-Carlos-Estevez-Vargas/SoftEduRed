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
										INSERT INTO relationship (description, state)
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
		 * @param string $idRelationship The id of the record to update.
		 * @param string $relationship The new value for 'description'.
		 * @param string $state The new value for 'state'.
		 *
		 * @throws Exception If there is an error updating the record.
		 *
		 * @return void
		 */
		public function updateRecord(string $idRelationship, string $relationship, string $state)
		{
				try {
						// Check that required fields are not empty
						if (!empty($idRelationship) && !empty($relationship)) {
								// Update the record in the database
								$sql = "
										UPDATE relationship
										SET description = UPPER(:description),
												state = :state
										WHERE id_relationship = :id
								";
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([
										'description' => $relationship,
										'state' => $state,
										'id' => $idRelationship
								]);

								// Show success message
								$this->showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/atributes/relationshipView.php'
								);
						} else {
								// Show warning message if required fields are empty
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/relationshipView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message if there is an error updating the record
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/relationshipView.php'
						);
						throw $e;
				}
		}

		/**
		 * Deletes a record from the relationship table based on the description of the relationship.
		 *
		 * @param string $idRelationship The ID of the relationship to delete.
		 * @return void
		 */
		public function deleteRelationship(string $idRelationship): void
		{
				try {
						if (!empty($idRelationship)) { // Check if ID is not empty
								$sql = "DELETE FROM relationship WHERE id_relationship = :id";
								$stmt = $this->pdo->prepare($sql);
								$stmt->bindParam(':id', $idRelationship, PDO::PARAM_STR);
								$stmt->execute();

								// Show success message and redirect to relationship view
								$this->showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/atributes/relationshipView.php'
								);
						} else {
								// Show warning message and redirect to relationship view
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/relationshipView.php'
								);
						}
				} catch (Exception $e) {
					echo $e->getMessage();
						// Show error message and redirect to relationship view
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