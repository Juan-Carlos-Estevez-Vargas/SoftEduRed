<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tipo de Documento</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
		require_once "../../persistence/database/Database.php";

		class DocumentTypeDAO
		{
				private $pdo;

				/**
				 * Class constructor
				 * Establishes a connection to the database using the database connector class.
				 *
				 * @throws Exception if connection to database fails
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
				 * Registers a new document type in the database
				 *
				 * @param string $documentType The code of the document type
				 * @param string $description The description of the document type
				 * @param string $state The state of the document type
				 * @return void
				 */
				public function registerDocumentType(string $documentType, string $description, string $state): void
				{
						try {
								if (!empty($documentType) && !empty($description)) {
										$sql = "
												INSERT INTO document_type (type, description, state)
												VALUES (UPPER(:documentType), UPPER(:description), :state)
										";
										
										$stmt = $this->pdo->prepare($sql);
										$stmt->bindParam(':documentType', $documentType);
										$stmt->bindParam(':description', $description);
										$stmt->bindParam(':state', $state);
										$stmt->execute();
		
										$this->showSuccessMessage(
												"Registro Agregado Exitosamente.",
												'../../views/atributes/documentTypeView.php'
										);
								} else {
										$this->showWarningMessage(
												"Debes llenar todos los campos.",
												'../../views/atributes/documentTypeView.php'
										);
								}
						} catch (Exception $e) {
								$this->showErrorMessage(
										"Ocurrió un error interno. Consulta al Administrador.",
										'../../views/atributes/documentTypeView.php'
								);
						}
				}

				/**
				 * Updates a document type record in the database.
				 *
				 * @param string $idDocumentType The id of the document type to be updated.
				 * @param string $type The new code of the document type.
				 * @param string $description The new description of the document type.
				 * @param string $state The new state of the document type
				 * @return void
				 */
				public function updateDocumentType(string $idDocumentType, string $type, string $description, string $state): void
				{
						try {
								// Check if all parameters are not empty.
								if (!empty($idDocumentType) && !empty($type) && !empty($description)) {
										$query = "
												UPDATE
														document_type
												SET
														type = UPPER(:type),
														description = UPPER(:description),
														state = :state
												WHERE
														id_document_type = :id
										";
										
										$statement = $this->pdo->prepare($query);
										$statement->execute([
												':type' => $type,
												':description' => $description,
												':state' => $state,
												':id' => $idDocumentType
										]);

										// If the update is successful, show a success message.
										$this->showSuccessMessage(
												"Registro Actualizado Exitosamente.",
												'../../views/atributes/documentTypeView.php'
										);
								} else {
										// If any parameter is empty, show a warning message.
										$this->showWarningMessage(
												"Debes llenar todos los campos.",
												'../../views/atributes/documentTypeView.php'
										);
								}
						} catch (Exception $e) {
								// If an error occurs, show an error message.
								$this->showErrorMessage(
										"Ocurrió un error interno. Consulta al Administrador.",
										'../../views/atributes/documentTypeView.php'
								);
						}
				}

				/**
				 * Deletes a record from the "document_type" table with the given document code.
				 *
				 * @param string $idDocumentType The document code to be deleted.
				 * @throws Exception If an error occurs during the deletion process.
				 * @return void
				 */
				public function deleteDocumentType(string $idDocumentType): void
				{
						try {
								if (!empty($idDocumentType)) {
										$query = "
												DELETE FROM document_type
												WHERE id_document_type = :id
										";
										$statement = $this->pdo->prepare($query);
										$statement->execute([':id' => $idDocumentType]);

										$this->showSuccessMessage(
												"Registro Eliminado Exitosamente.",
												'../../views/atributes/documentTypeView.php'
										);
								} else {
										$this->showWarningMessage(
												"Debes llenar todos los campos.",
												'../../views/atributes/documentTypeView.php'
										);
								}
						} catch (Exception $e) {
								$this->showErrorMessage(
										"Ocurrió un error interno. Consulta al Administrador.",
										'../../views/atributes/documentTypeView.php'
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