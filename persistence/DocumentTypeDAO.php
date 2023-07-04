<body>
  <?php
		require_once '../utils/Message.php';

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
				 * @return void
				 */
				public function register(string $documentType, string $description): void
				{
						try {
								$sql = "
										INSERT INTO document_type (type, description, state)
										VALUES (UPPER(:documentType), UPPER(:description), 1)
								";
								$stmt = $this->pdo->prepare($sql);
								$stmt->bindParam(':documentType', trim($documentType));
								$stmt->bindParam(':description', trim($description));
								$stmt->execute();
						} catch (Exception $e) {
								Message::showErrorMessage(
										"Ocurrió un error interno. Consulta al Administrador.",
										'../../views/documentTypeView.php'
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
				public function update(string $idDocumentType, string $type, string $description, string $state): void
				{
						try {
								$query = "
										UPDATE document_type
										SET type = UPPER(:type),
												description = UPPER(:description),
												state = :state
										WHERE id_document_type = :id
								";
								
								$statement = $this->pdo->prepare($query);
								$statement->execute([
										':type' => trim($type),
										':description' => trim($description),
										':state' => $state,
										':id' => $idDocumentType
								]);
						} catch (Exception $e) {
								// If an error occurs, show an error message.
								Message::showErrorMessage(
										"Ocurrió un error interno. Consulta al Administrador.",
										'../../views/documentTypeView.php'
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
				public function delete(string $idDocumentType): void
				{
						try {
								$query = "
										UPDATE document_type
										SET	state = 3
										WHERE	id_document_type = :id
								";
								$statement = $this->pdo->prepare($query);
								$statement->execute([':id' => $idDocumentType]);
						} catch (Exception $e) {
								Message::showErrorMessage(
										"Ocurrió un error interno. Consulta al Administrador.",
										'../../views/documentTypeView.php'
								);
						}
				}
		}
?>