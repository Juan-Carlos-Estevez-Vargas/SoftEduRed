<?php
	require_once '../persistence/database/Database.php';
	require_once '../persistence/DocumentTypeDAO.php';
	require_once '../utils/Message.php';
	require_once '../utils/constants.php';

	class DocumentTypeService
	{
		/**
		 * Class constructor.
		 *
		 * Initializes a connection to the database by creating an instance of the DocumentTypeDAO class.
		 *
		 * @throws Exception if connection to database fails
		 */
		public function __construct()
		{
			try {
				// Create a new instance of the DocumentTypeDAO class
				$this->documentType = new DocumentTypeDAO();
			} catch (Exception $e) {
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
				// Check if both document type and description are not empty
				if (!empty($documentType) && !empty($description)) {
					// Check if the document type or description is already registered
					if (Message::isRegistered(Database::connect(), 'document_type', 'type', $documentType, false, null)
						|| Message::isRegistered(Database::connect(), 'document_type', 'description', $description, false, null))
					{
						// Show error message if document type or description is already registered
						Message::showErrorMessage(DOCUMENT_TYPE_ALREADY_ADDED, DOCUMENT_TYPE_URL);
						return;
					}
					
					// Register the document type
					$this->documentType->register($documentType, $description);
									
					// Show success message after registration
					Message::showSuccessMessage(ADDED_RECORD, DOCUMENT_TYPE_URL);
				} else {
					// Show warning message if any of the fields are empty
					Message::showWarningMessage(EMPTY_FIELDS, DOCUMENT_TYPE_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, DOCUMENT_TYPE_URL);
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
						&& Message::isRegistered(Database::connect(), 'document_type', 'description', $description, true, $idDocumentType, 'id_document_type'))
					{
						Message::showErrorMessage(DOCUMENT_TYPE_ALREADY_ADDED, DOCUMENT_TYPE_URL);
						return;
					}
					
					$this->documentType->update($idDocumentType, $type, $description, $state);
					
					// If the update is successful, show a success message.
					Message::showSuccessMessage(UPDATED_RECORD, DOCUMENT_TYPE_URL);
				} else {
					// If any parameter is empty, show a warning message.
					Message::showWarningMessage(EMPTY_FIELDS, DOCUMENT_TYPE_URL);
				}
			} catch (Exception $e) {
				// If an error occurs, show an error message.
				Message::showErrorMessage(INTERNAL_ERROR, DOCUMENT_TYPE_URL);
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

					// Show success message
					Message::showSuccessMessage(DELETED_RECORD, DOCUMENT_TYPE_URL);
				} else {
					// Show warning message
					Message::showWarningMessage(EMPTY_FIELDS, DOCUMENT_TYPE_URL);
				}
			} catch (Exception $e) {
				// Show error message
				Message::showErrorMessage(INTERNAL_ERROR, DOCUMENT_TYPE_URL);
			}
		}

		/**
		 * Retrieves the document type by its ID.
		 *
		 * @param int $id The ID of the document type.
		 * @throws Exception If an error occurs during the retrieval process.
		 * @return mixed The document type object if found, or null.
		 */
		public function getDocumentTypeById(int $id)
		{
			try {
				if (!empty($id)) {
					return $this->documentType->getDocumentTypeById($id);
				} else {
					Message::showWarningMessage(INTERNAL_ERROR, DOCUMENT_TYPE_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, DOCUMENT_TYPE_URL);
			}
		}

		/**
		 * Retrieves the document type list data for a given page.
		 *
		 * @param mixed $page The page number.
		 * @throws Exception If an error occurs while retrieving the list data.
		 * @return mixed The document type list data.
		 */
		public function getDocumentTypeListData($page)
		{
			try {
				if (!empty($page)) {
					return $this->documentType->getDocumentTypeListData($page);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, DOCUMENT_TYPE_URL);
			}
		}
	}
?>