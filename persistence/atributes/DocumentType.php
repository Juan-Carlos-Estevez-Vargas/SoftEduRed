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
	class DocumentType
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
			$sql = "INSERT INTO type_of_document (cod_document, Des_doc)
							VALUES (:doc, :descDoc)";
			$stmt = $this->pdo->prepare($sql);
			$stmt->bindParam(':doc', $doc);
			$stmt->bindParam(':descDoc', $descDoc);
			$stmt->execute();

			print "
				<script>
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Registro Agregado Exitosamente.',
						showConfirmButton: false,
						timer: 2000
					}).then(() => {
							window.location = '../../views/atributes/documentTypeView.php';
					});
				</script>
			";
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
			$query = "UPDATE type_of_document
								SET cod_document = UPPER(:code), Des_doc = UPPER(:description)
								WHERE cod_document = :oldCode";

			$statement = $this->pdo->prepare($query);
			$statement->execute([
					':code' => $code,
					':description' => $description,
					':oldCode' => $oldCode
			]);

			echo "
				<script>
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Registro Actualizado Exitosamente.',
						showConfirmButton: false,
						timer: 2000
					}).then(() => {
							window.location = '../../views/atributes/documentTypeView.php';
					});
				</script>
			";
		}

		/**
		 * Deletes a record from the "type_of_document" table with the given document code
		 *
		 * @param string $doc The document code to be deleted
		 * @return void
		 */
		public function deleteDocumentType(string $doc)
		{
			$query = "DELETE FROM type_of_document WHERE cod_document = :doc";
			$statement = $this->pdo->prepare($query);
			$statement->execute([':doc' => $doc]);

			echo "
				<script>
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Registro Eliminado Exitosamente.',
						showConfirmButton: false,
						timer: 2000
					}).then(() => {
							window.location = '../../views/atributes/documentTypeView.php';
					});
				</script>
			";
		}
	}
?>
</body>

</html>