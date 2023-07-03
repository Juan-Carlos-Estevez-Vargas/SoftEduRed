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
		require_once '../persistence/database/Database.php';
		require_once '../persistence/DocumentTypeDAO.php';
		require_once '../utils/Message.php';

		class DocumentTypeService
		{
        /**
         * Class constructor.
         * Establishes a connection to the database using the database connector class.
         *
         * @throws Exception if connection to database fails
         */
        public function __construct()
        {
            try {
                // Create a new instance of the DocumentTypeDAO class
                $this->documentType = new DocumentTypeDAO();
            } catch (Exception $e) {
                // Rethrow the exception as a PDOException
                throw new Exception($e->getMessage());
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
								if (!empty($documentType) && !empty($description)) {
                    if (Message::isRegistered(Database::connect(), 'document_type', 'type', $documentType, false, null)
                      || Message::isRegistered(Database::connect(), 'document_type', 'description', $description, false, null))
                    {
                        Message::showErrorMessage(
                            "El tipo de documento ingresado ya se encuentra registrado en la plataforma",
                            '../../views/documentTypeView.php'
                        );
                        return;
                    }
                    
                    $this->documentType->register($documentType, $description);
												
										Message::showSuccessMessage(
												"Registro Agregado Exitosamente.",
												'../../views/documentTypeView.php'
										);
								} else {
										Message::showWarningMessage(
												"Debes llenar todos los campos.",
												'../../views/documentTypeView.php'
										);
								}
						} catch (Exception $e) {
                echo $e->getMessage();
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
								// Check if all parameters are not empty.
								if (!empty($idDocumentType) && !empty($type) && !empty($description)) {
                    if (Message::isRegistered(Database::connect(), 'document_type', 'type', $type, true, $idDocumentType, 'id_document_type')
                      || Message::isRegistered(Database::connect(), 'document_type', 'description', $description, true, $idDocumentType, 'id_document_type'))
                    {
                        Message::showErrorMessage(
                            "El tipo de documento ingresado ya se encuentra registrado en la plataforma",
                            '../../views/documentTypeView.php'
                        );
                        return;
                    }
                
                    $this->documentType->update($idDocumentType, $type, $description, $state);
										
										// If the update is successful, show a success message.
										Message::showSuccessMessage(
												"Registro Actualizado Exitosamente.",
												'../../views/documentTypeView.php'
										);
								} else {
										// If any parameter is empty, show a warning message.
										Message::showWarningMessage(
												"Debes llenar todos los campos.",
												'../../views/documentTypeView.php'
										);
								}
						} catch (Exception $e) {
                echo $e->getMessage();
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
								if (!empty($idDocumentType)) {
                    $this->documentType->delete($idDocumentType);

										Message::showSuccessMessage(
												"Registro Eliminado Exitosamente.",
												'../../views/documentTypeView.php'
										);
								} else {
										Message::showWarningMessage(
												"Debes llenar todos los campos.",
												'../../views/documentTypeView.php'
										);
								}
						} catch (Exception $e) {
								Message::showErrorMessage(
										"Ocurrió un error interno. Consulta al Administrador.",
										'../../views/documentTypeView.php'
								);
						}
				}
		}
	?>
</body>

</html>