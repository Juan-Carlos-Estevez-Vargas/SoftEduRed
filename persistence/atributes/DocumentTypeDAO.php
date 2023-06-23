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
				 * @param string $doc The code of the document type
				 * @param string $descDoc The description of the document type
				 * @return void
				 */
				public function registerDocumentType(string $doc, string $descDoc): void
				{
						try {
								if (!empty($doc) && !empty($descDoc)) {
										$sql = "INSERT INTO type_of_document (cod_document, Des_doc) VALUES (UPPER(:doc), UPPER(:descDoc))";
										$stmt = $this->pdo->prepare($sql);
										$stmt->bindParam(':doc', $doc);
										$stmt->bindParam(':descDoc', $descDoc);
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
				 * @param string $code The new code of the document type.
				 * @param string $oldCode The current code of the document type to be updated.
				 * @param string $description The new description of the document type.
				 */
				public function updateDocumentType(string $code, string $oldCode, string $description): void
				{
						try {
								if (!empty($code) && !empty($oldCode) && !empty($description)) {
										$query = "
												UPDATE type_of_document
												SET cod_document = UPPER(:code),
														Des_doc = UPPER(:description)
												WHERE cod_document = :oldCode
										";
										
										$statement = $this->pdo->prepare($query);
										$statement->execute([
												':code' => $code,
												':description' => $description,
												':oldCode' => $oldCode
										]);

										$this->showSuccessMessage(
												"Registro Actualizado Exitosamente.",
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
				 * Deletes a record from the "type_of_document" table with the given document code
				 *
				 * @param string $doc The document code to be deleted
				 * @return void
				 */
				public function deleteDocumentType(string $doc): void
				{
						try {
								if (!empty($doc)) {
										$query = "DELETE FROM type_of_document WHERE cod_document = :doc";
										$statement = $this->pdo->prepare($query);
										$statement->execute([':doc' => $doc]);
		
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
										'../../views/atributes/documentTypeView.php
								');
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